<?php
session_start();
include('dbConfig.php');
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // File submitted check
    if (!isset($_FILES['xml_file']['tmp_name'])) {
        echo ('No File');
    }
    // Lê o arquivo enviado pelo formulário
    $xml_file = $_FILES['xml_file']['tmp_name'];
    $xml_file_name = $_FILES['xml_file']['name'];
    $extension = pathinfo($xml_file_name, PATHINFO_EXTENSION);


    // File extension check
    if ($extension !== 'xml') {
        echo ('Not Supported File');
    }

    // Converte o arquivo em uma string XML
    $xml = simplexml_load_file($xml_file);

    // File version check
    if ($xml->Header->AuditFileVersion != '1.04_01') {
        echo ('Different File Version');
    }
    //unset($_SESSION['CompanyID']);
    //unset($_SESSION['DateCreated']);

    $productsInserted = 0;
    $numInvoicesInserted = 0;
    $totalLines = 0;

    $CompanyID = (string) $xml->Header->CompanyID;
    $CompanyName = (string) $xml->Header->CompanyName;
    $AddressDetail = (string) $xml->Header->CompanyAddress->AddressDetail;
    $City = (string) $xml->Header->CompanyAddress->City;
    $PostalCode = (string) $xml->Header->CompanyAddress->PostalCode;
    $Country = (string) $xml->Header->CompanyAddress->Country;
    $xmlDate = (string) $xml->Header->StartDate;
    $NumberOfEntries = (string) $xml->SourceDocuments->SalesInvoices->NumberOfEntries;
    $TotalCredit = (string) $xml->SourceDocuments->SalesInvoices->TotalCredit;

    $_SESSION['CompanyID'] = $CompanyID;
    $_SESSION['DateCreated'] = $xmlDate;

    //echo $_SESSION['CompanyID'] . "   Company ID: " . $CompanyID;

    // Check if a record with the same CompanyID and DateCreated already exists
    $sqlSelectCompany = "SELECT CompanyID, DateCreated FROM empresas WHERE CompanyID = :CompanyID and DateCreated = :DateCreated";
    $stmt = $pdo->prepare($sqlSelectCompany);
    $stmt->bindParam(':CompanyID', $CompanyID);
    $stmt->bindParam(':DateCreated', $xmlDate);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // A record with the same CompanyID and DateCreated already exists
        echo "duplicado";
    } else {
        try {
            // Iniciar uma nova transação
            $pdo->beginTransaction();

            //preparação da query SQL
            $sqlInsertCompany = "INSERT INTO empresas (CompanyID, CompanyName, AddressDetail, City, PostalCode, Country, DateCreated, NumberOfEntries, TotalCredit) VALUES (:CompanyID, :CompanyName, :AddressDetail, :City, :PostalCode, :Country, :xmlDate, :NumberOfEntries, :TotalCredit)";

            //preparação do statement PDO
            $stmt = $pdo->prepare($sqlInsertCompany);

            //bind dos parâmetros
            $stmt->bindParam(':CompanyID', $CompanyID);
            $stmt->bindParam(':CompanyName', $CompanyName);
            $stmt->bindParam(':AddressDetail', $AddressDetail);
            $stmt->bindParam(':City', $City);
            $stmt->bindParam(':PostalCode', $PostalCode);
            $stmt->bindParam(':Country', $Country);
            $stmt->bindParam(':xmlDate', $xmlDate);
            $stmt->bindParam(':NumberOfEntries', $NumberOfEntries);
            $stmt->bindParam(':TotalCredit', $TotalCredit);
            $stmt->execute();
            //execução do insert

            foreach ($xml->MasterFiles->Customer as $customer) {

                //Percorrer os Customer e Guardar nas Variavéis
                $customerID = (string) $customer->CustomerID;
                $customerTaxID = (string) $customer->CustomerTaxID;
                $customerName = (string) $customer->CompanyName;
                $customerAddressDetail = (string) $customer->BillingAddress->AddressDetail;
                $customerCity = (string) $customer->BillingAddress->City;
                $customerPostalCode = (string) $customer->BillingAddress->PostalCode;
                $customerRegion = (string) $customer->BillingAddress->Region;
                $customerCountry = (string) $customer->BillingAddress->Country;

                //preparação da query SQL
                $sqlInsertCustomer = "INSERT INTO clientes (CustomerID, CustomerTaxID, CompanyName, AddressDetail, City, PostalCode, Region, Country, CompanyID, SaftDate) 
            VALUES (:CustomerID, :CustomerTaxID, :CompanyName, :AddressDetail, :City, :PostalCode, :Region, :Country, :CompanyID, :SaftDate)";

                //preparação do statement PDO
                $stmt = $pdo->prepare($sqlInsertCustomer);

                //bind dos parâmetros
                $stmt->bindParam(':CustomerID', $customerID);
                $stmt->bindParam(':CustomerTaxID', $customerTaxID);
                $stmt->bindParam(':CompanyName', $customerName);
                $stmt->bindParam(':AddressDetail', $customerAddressDetail);
                $stmt->bindParam(':City', $customerCity);
                $stmt->bindParam(':PostalCode', $customerPostalCode);
                $stmt->bindParam(':Region', $customerRegion);
                $stmt->bindParam(':Country', $customerCountry);
                $stmt->bindParam(':CompanyID', $CompanyID);
                $stmt->bindParam(':SaftDate', $xmlDate);
                $stmt->execute();
                //execução do insert
            }

            while ($productsInserted !== count($xml->SourceDocuments->SalesInvoices->Invoice->Line) and $numInvoicesInserted !== count($xml->SourceDocuments->SalesInvoices->Invoice)) {
                foreach ($xml->SourceDocuments->SalesInvoices->Invoice as $invoice) {
                    $InvoiceNo = (string) $invoice->InvoiceNo;
                    $InvoiceDate = (string) date('Y-m-d H:i:s', strtotime($invoice->SystemEntryDate));
                    $CustomerID = (string) $invoice->CustomerID;
                    $numLines = count($invoice->Line);
                    $totalLines += $numLines;

                    //preparação da query SQL
                    $sqlInsertInvoice = "INSERT INTO faturas (InvoiceNo, InvoiceDate, CustomerID, CompanyID, SaftDate) 
                    VALUES (:InvoiceNo, :InvoiceDate, :CustomerID, :CompanyID, :SaftDate)";

                    //preparação do statement PDO
                    $stmt = $pdo->prepare($sqlInsertInvoice);

                    //bind dos parâmetros
                    $stmt->bindParam(':InvoiceNo', $InvoiceNo);
                    $stmt->bindParam(':InvoiceDate', $InvoiceDate);
                    $stmt->bindParam(':CustomerID', $CustomerID);
                    $stmt->bindParam(':CompanyID', $CompanyID);
                    $stmt->bindParam(':SaftDate', $xmlDate);

                    //execução do insert
                    if ($stmt->execute()) {
                        $numInvoicesInserted++;
                    }

                    foreach ($invoice->Line as $line) {
                        $ProductCode = (string) $line->ProductCode;
                        $ProductDescription = (string) $line->ProductDescription;
                        $Quantity = (int) $line->Quantity;
                        $CreditAmount = (float) $line->CreditAmount;

                        //preparação da query SQL
                        $sqlInsertProduct = "INSERT INTO produtos (ProductCode, ProductDescription, Quantity, CreditAmount, InvoiceNo, CompanyID, SaftDate, InvoiceDate) 
                    VALUES (:ProductCode, :ProductDescription, :Quantity, :CreditAmount, :InvoiceNo, :CompanyID, :SaftDate, :InvoiceDate)";

                        //preparação do statement PDO
                        $stmt = $pdo->prepare($sqlInsertProduct);

                        //bind dos parâmetros
                        $stmt->bindParam(':ProductCode', $ProductCode);
                        $stmt->bindParam(':ProductDescription', $ProductDescription);
                        $stmt->bindParam(':Quantity', $Quantity);
                        $stmt->bindParam(':CreditAmount', $CreditAmount);
                        $stmt->bindParam(':InvoiceNo', $InvoiceNo);
                        $stmt->bindParam(':CompanyID', $CompanyID);
                        $stmt->bindParam(':SaftDate', $xmlDate);
                        $stmt->bindParam(':InvoiceDate', $InvoiceDate);

                        //execução do insert
                        if ($stmt->execute()) {
                            $productsInserted++;
                        } else {
                        }
                    }
                }
            }
            //verifica se todos os produtos foram inseridos
            if ($productsInserted == $totalLines and $numInvoicesInserted == count($xml->SourceDocuments->SalesInvoices->Invoice)) {
                $pdo->commit();
                echo "successo";
            } else {
                echo "erro";
            }
        } catch (PDOException $e) {
            // Rollback da transação em caso de erro
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
