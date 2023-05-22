<?php
include('dbConfig.php');
session_start();
$CompanyID = $_SESSION['CompanyID'];
$DateCreated = $_SESSION['DateCreated'];

$sqlSelectCompany = "SELECT * FROM empresas WHERE CompanyID = :CompanyID and DateCreated = :DateCreated";
$stmt = $pdo->prepare($sqlSelectCompany);
$stmt->bindParam(':CompanyID', $CompanyID);
$stmt->bindParam(':DateCreated', $DateCreated);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // A record with the same CompanyID and DateCreated already exists

    //Buscar os Dados da Empresa
    //Buscar os Dados da Empresa
    //Buscar os Dados da Empresa
    $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
    $CompanyName = $empresa['CompanyName'];
    $CompanyAddressDetail = $empresa['AddressDetail'];
    $CompanyCity = $empresa['City'];
    $CompanyPostalCode = $empresa['PostalCode'];
    $CompanyCountry = $empresa['Country'];
    $NumberOfEntries = $empresa['NumberOfEntries'];
    $TotalCredit = $empresa['TotalCredit'];


    //Agrupar Por Dias
    //Agrupar Por Dias
    //Agrupar Por Dias
    $sql = "SELECT DATE_FORMAT(InvoiceDate, '%d-%m-%Y') as Date, SUM(Quantity) as TotalProducts, SUM(CreditAmount) as TotalSales FROM produtos WHERE CompanyID = :CompanyID AND SaftDate = :SaftDate /*AND YEAR(InvoiceDate) = YEAR(:SaftDate) AND MONTH(InvoiceDate) = MONTH(:SaftDate)*/ GROUP BY DATE_FORMAT(InvoiceDate, '%d-%m-%Y');";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':SaftDate', $DateCreated);
    $stmt->execute();

    $results_graficos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Converter os resultados em um array no formato esperado pelo Google Charts
    $DiasArray = array(
        array('Dia', 'Produtos', 'Receita')
    );
    foreach ($results_graficos as $row) {
        $DiasArray[] = array($row['Date'], (int) $row['TotalProducts'], (int) $row['TotalSales']);
    }


    $totalProducts = 0;
    $ReceitaDiariaArray = array(
        array('Dia', 'Receita')
    );

    $ProdutosDiariosArray = array(
        array('Dia', 'Produtos')
    );
    foreach ($results_graficos as $row) {
        $ReceitaDiariaArray[] = array($row['Date'], (int) $row['TotalSales']);
        $ProdutosDiariosArray[] = array($row['Date'], (int) $row['TotalProducts']);
        $totalProducts += $row['TotalProducts'];
    }
    $Receita_Produtos = array(
        $ReceitaDiariaArray,
        $ProdutosDiariosArray
    );

    //Agrupar Por Dias Da Semana
    //Agrupar Por Dias Da Semana
    //Agrupar Por Dias Da Semana
    $sql = "SELECT 
    CASE WEEKDAY(InvoiceDate)
      WHEN 0 THEN 'Segunda-feira'
      WHEN 1 THEN 'Terça-feira'
      WHEN 2 THEN 'Quarta-feira'
      WHEN 3 THEN 'Quinta-feira'
      WHEN 4 THEN 'Sexta-feira'
      WHEN 5 THEN 'Sábado'
      WHEN 6 THEN 'Domingo'
    END AS DayOfWeek,
    SUM(Quantity) AS TotalProducts,
    SUM(CreditAmount) AS TotalSales
  FROM produtos
  WHERE CompanyID = :CompanyID
    AND SaftDate = :SaftDate
    /*AND YEAR(InvoiceDate) = YEAR(:SaftDate)
    AND MONTH(InvoiceDate) = MONTH(:SaftDate)*/
  GROUP BY WEEKDAY(InvoiceDate)
  ORDER BY WEEKDAY(InvoiceDate);";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':SaftDate', $DateCreated);
    $stmt->execute();

    $results_dias_semana = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Converter os resultados em um array no formato esperado pelo Google Charts
    $DiasDaSemanaArray = array(
        array('Dia', 'Produtos', 'Receita')
    );
    foreach ($results_dias_semana as $row) {
        // $row['TotalSales'] = '€' . number_format((float) $row['TotalSales'], 2, ',', '.');
        $DiasDaSemanaArray[] = array($row['DayOfWeek'], (int) $row['TotalProducts'], floatval($row['TotalSales']));
    }

    //Agrupar Por Horas
    //Agrupar Por Horas
    //Agrupar Por Horas
    $sql = "SELECT DATE_FORMAT(InvoiceDate, '%H') as Hour, SUM(Quantity) as TotalProducts, SUM(CreditAmount) as TotalSales FROM produtos WHERE CompanyID = :CompanyID AND SaftDate = :SaftDate /*AND YEAR(InvoiceDate) = YEAR(:SaftDate) AND MONTH(InvoiceDate) = MONTH(:SaftDate)*/ GROUP BY DATE_FORMAT(InvoiceDate, '%H') ORDER BY Hour ASC;";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':SaftDate', $DateCreated);
    $stmt->execute();

    $results_horas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Converter os resultados em um array no formato esperado pelo Google Charts
    $ReceitaHoraArray = array(
        array('Hora', 'Receita')
    );

    $ProdutosHoraArray = array(
        array('Hora', 'Produtos')
    );

    $totalProducts = 0;
    foreach ($results_horas as $row) {
        $ReceitaHoraArray[] = array($row['Hour'], (int) $row['TotalSales']);
        $ProdutosHoraArray[] = array($row['Hour'], (int) $row['TotalProducts']);
        $totalProducts += $row['TotalProducts'];
    }
    $HorasArray = array(
        array('Hora', 'Produtos', 'Receita')
    );

    foreach ($results_horas as $row) {
        $HorasArray[] = array($row['Hour'], (int) $row['TotalProducts'], (int) $row['TotalSales']);
    }

    //Pesquisar os Clientes e fazer o TOP10
    //Pesquisar os Clientes e fazer o TOP10
    //Pesquisar os Clientes e fazer o TOP10
    $sql = "SELECT COUNT(*) as TotalClientes FROM clientes WHERE CompanyID = :CompanyID AND SaftDate = :SaftDate;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':SaftDate', $DateCreated);
    $stmt->execute();
    $results_total_clientes = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalClientes = $results_total_clientes['TotalClientes'];

    $sql = "SELECT c.CustomerID, c.CompanyName, COUNT(*) as TotalPurchases 
        FROM faturas f 
        JOIN clientes c ON f.CustomerID = c.CustomerID 
        WHERE f.CompanyID = :CompanyID AND f.SaftDate = :SaftDate 
        GROUP BY f.CustomerID, c.CompanyName 
        ORDER BY TotalPurchases DESC 
        LIMIT 10;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':SaftDate', $DateCreated);
    $stmt->execute();
    $results_clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $top_customers = array();
    foreach ($results_clientes as $row) {
        $CustomerID = $row['CustomerID'];
        $ClientCompanyName = $row['CompanyName'];
        $TotalPurchases = $row['TotalPurchases'];
        $top_customers[$CustomerID] = [
            'CompanyName' => $ClientCompanyName,
            'TotalPurchases' => $TotalPurchases
        ];
    }


    //Pesquisar os Produtos e fazer o TOP10
    //Pesquisar os Produtos e fazer o TOP10
    //Pesquisar os Produtos e fazer o TOP10
    $sql = "SELECT COUNT(*) as TotalProducts FROM produtos WHERE CompanyID = :CompanyID AND SaftDate = :SaftDate;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':SaftDate', $DateCreated);
    $stmt->execute();
    $results_total_produtos = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalProdutos = $results_total_produtos['TotalProducts'];

    $sql = "SELECT ProductCode, ProductDescription, SUM(Quantity) AS total_vendido, SUM(Quantity * CreditAmount) AS total_dinheiro
    FROM produtos
    WHERE CompanyID = :CompanyID AND SaftDate = :SaftDate
    GROUP BY ProductCode, ProductDescription
    ORDER BY total_dinheiro DESC
    LIMIT 10;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':SaftDate', $DateCreated);
    $stmt->execute();
    $results_produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $top_produtos = array();
    foreach ($results_produtos as $row) {
        $ProductCode = $row['ProductCode'];
        $ProductDescription = $row['ProductDescription'];
        $total_vendido = $row['total_vendido'];
        $total_dinheiro = $row['total_dinheiro'];
        $top_produtos[$ProductCode] = [
            'ProductDescription' => $ProductDescription,
            'total_vendido' => $total_vendido,
            'total_dinheiro' => $total_dinheiro
        ];
    }

    //Gasto Medio Por Cliente
    //Gasto Medio Por Cliente
    //Gasto Medio Por Cliente
    $sql = "SELECT c.CustomerID, c.CompanyName, COUNT(DISTINCT p.InvoiceNo) as TotalCompras, SUM(p.CreditAmount) as TotalGasto, AVG(p.CreditAmount) as MediaGasto 
    FROM faturas f 
    JOIN clientes c ON f.CustomerID = c.CustomerID 
    JOIN produtos p ON f.InvoiceNo = p.InvoiceNo 
    WHERE f.CompanyID = :CompanyID
    AND f.SaftDate = :SaftDate
    /*AND YEAR(f.InvoiceDate) = YEAR('2021-06-01') 
    AND MONTH(f.InvoiceDate) = MONTH('2021-06-01') */
    GROUP BY c.CustomerID, c.CompanyName LIMIT 10;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':SaftDate', $DateCreated);
    $stmt->execute();

    $results_gasto_cliente = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Converter os resultados em um array no formato esperado pelo Google Charts
    $GastoMedioClienteArray = array(
        array('Dia', 'Produtos', 'Receita')
    );
    foreach ($results_gasto_cliente as $row) {
        // $row['TotalSales'] = '€' . number_format((float) $row['TotalSales'], 2, ',', '.');
        $GastoMedioClienteArray[] = array((int) $row['CustomerID'], (string) $row['CompanyName'], (int) $row['TotalCompras'], floatval($row['TotalGasto']), floatval($row['MediaGasto']));
    }

    $sql = "SELECT AVG(p.CreditAmount) as MediaGasto FROM faturas f JOIN clientes c ON f.CustomerID = c.CustomerID JOIN produtos p ON f.InvoiceNo = p.InvoiceNo WHERE f.CompanyID = :CompanyID AND f.SaftDate = :SaftDate /*AND YEAR(f.InvoiceDate) = YEAR('2021-06-01') AND MONTH(f.InvoiceDate) = MONTH('2021-06-01')*/";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':SaftDate', $DateCreated);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $MediaGasto = $result['MediaGasto'];
} else {
    echo "erro";
}
