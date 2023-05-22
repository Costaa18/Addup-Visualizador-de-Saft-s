<?php include('php/obterDados.php'); ?>
<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
  <base href="" />
  <title>Index</title>
  <meta charset="utf-8" />
  <meta name="description" content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
  <meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="Metronic - Bootstrap Admin Template, HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express.js, Node.js, Flask Admin Dashboard Theme & Template" />
  <meta property="og:url" content="https://keenthemes.com/metronic" />
  <meta property="og:site_name" content="Keenthemes | Metronic" />
  <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
  <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
  <!--begin::Fonts(mandatory for all pages)-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
  <!--end::Fonts-->
  <!--begin::Vendor Stylesheets(used for this page only)-->
  <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />
  <!--end::Vendor Stylesheets-->
  <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
  <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!--Tabelas-->
  <!--Tabelas-->
  <!--Tabelas-->
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['table']
    });
    google.charts.setOnLoadCallback(drawTable);

    // Cria um objeto DataTable
    function drawTable() {
      // Cria um objeto DataTable~
      //Dias da Semana
      //Dias da Semana
      //Dias da Semana
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Dia da Semana');
      data.addColumn('number', 'Total de Produtos');
      data.addColumn('number', 'Receita Total');
      <?php $firstIteration = true; ?>
      <?php foreach ($DiasDaSemanaArray as $row) { ?>
        <?php if ($firstIteration) { ?>
          <?php $firstIteration = false; ?>
        <?php } else { ?>
          data.addRows([
            ['<?php echo $row[0]; ?>', <?php echo $row[1]; ?>, <?php echo $row[2]; ?>]
          ]);
        <?php } ?>
      <?php } ?>


      // Define o formato da coluna "Receita Total"
      var formatter = new google.visualization.NumberFormat({
        suffix: '€',
        decimalSymbol: ',',
        groupingSymbol: '.',
        fractionDigits: 2
      });
      formatter.format(data, 2);

      // Cria uma tabela e a desenha
      var table = new google.visualization.Table(document.getElementById('table_div'));
      table.draw(data, {
        showRowNumber: true,
        width: '100%',
        height: '100%'
      });

      //Media Gasta Por Cliente
      //Media Gasta Por Cliente
      var gastoClientedata = new google.visualization.DataTable();
      gastoClientedata.addColumn('string', 'Id do Cliente');
      gastoClientedata.addColumn('string', 'Nome do Cliente');
      gastoClientedata.addColumn('number', 'Nº Total de Compras');
      gastoClientedata.addColumn('number', 'Total Gasto');
      gastoClientedata.addColumn('number', 'Valor Médio Gasto');
      <?php $firstIteration = true; ?>
      <?php foreach ($GastoMedioClienteArray as $row) { ?>
        <?php if ($firstIteration) { ?>
          <?php $firstIteration = false; ?>
        <?php } else { ?>
          gastoClientedata.addRows([
            ['<?php echo $row[0]; ?>', '<?php echo $row[1]; ?>', <?php echo $row[2]; ?>, <?php echo $row[3]; ?>, <?php echo $row[4]; ?>]
          ]);
        <?php } ?>
      <?php } ?>


      // Define o formato da coluna "Receita Total"
      formatter.format(gastoClientedata, 3);
      formatter.format(gastoClientedata, 4);

      // Cria uma tabela e a desenha
      var table = new google.visualization.Table(document.getElementById('gastoCliente_div'));
      table.draw(gastoClientedata, {
        showRowNumber: true,
        width: '100%',
        height: '100%'
      });
    }
  </script>
  <!--Graficos-->
  <!--Graficos-->
  <!--Graficos-->
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);
    $(window).resize(function() {
      drawChart();
    });

    function drawChart() {
      var formatter = new google.visualization.NumberFormat({
        suffix: '€',
        decimalSymbol: ',',
        groupingSymbol: '.',
        fractionDigits: 2
      });
      //Grafico Receita Diaria
      //Grafico Receita Diaria
      //Grafico Receita Diaria
      var dataReceitaDiaria = google.visualization.arrayToDataTable(<?php echo json_encode($ReceitaDiariaArray); ?>);

      var optionsReceitaDiaria = {
        responsive: true,
        title: 'Receita por dia',
        curveType: 'function',
        legend: {
          position: 'none'
        },
        hAxis: {
          title: 'Dia'
        },
        vAxis: {
          title: 'Receita (€)'
        }
      };
      formatter.format(dataReceitaDiaria, 1);
      var chartReceitaDiaria = new google.visualization.LineChart(document.getElementById('chartReceitaDiaria'));

      chartReceitaDiaria.draw(dataReceitaDiaria, optionsReceitaDiaria);

      //Grafico Produtos Diarios
      //Grafico Produtos Diarios
      //Grafico Produtos Diarios
      var dataProdutosDiarios = google.visualization.arrayToDataTable(<?php echo json_encode($ProdutosDiariosArray); ?>);

      var optionsProdutosDiarios = {
        title: 'Produtos Por Dia',
        curveType: 'function',
        legend: {
          position: 'none'
        },
        hAxis: {
          title: 'Dia'
        },
        vAxis: {
          title: 'Produtos'
        }
      };

      var chartProdutosDiarios = new google.visualization.LineChart(document.getElementById('chartProdutosDiariosArray'));

      chartProdutosDiarios.draw(dataProdutosDiarios, optionsProdutosDiarios);


      //Grafico TOP10 Clientes
      //Grafico TOP10 Clientes
      //Grafico TOP10 Clientes
      var topCostumerData = google.visualization.arrayToDataTable([
        ['Nome do Cliente', 'Vendas Totais', {
          role: 'annotation'
        }],
        <?php foreach ($top_customers as $CustomerID => $data) {
          echo "['{$data['CompanyName']}', {$data['TotalPurchases']}, '{$CustomerID}'],";
        } ?>
      ]);

      var topCostumerView = new google.visualization.DataView(topCostumerData);
      topCostumerView.setColumns([0, 1, {
        calc: "stringify",
        sourceColumn: 1,
        type: "string",
        role: "annotation"
      }]);

      var topCostumerOptions = {
        title: "Top 10 Clientes por Vendas Totais",
        width: 700,
        height: 500,
        chartArea: {
          left: 80,
          top: 80,
          right: 80,
          bottom: 80
        },
        hAxis: {
          title: 'Vendas Totais',
          minValue: 0,
          textStyle: {
            fontSize: 12
          }
        },
        vAxis: {
          title: 'Nome do Cliente',
          textStyle: {
            fontSize: 12
          }
        },
        bar: {
          groupWidth: '70%'
        },
        legend: {
          position: "none"
        },
        annotations: {
          textStyle: {
            fontSize: 12,
            bold: true
          }
        }
      };

      var topCostumerChart = new google.visualization.BarChart(document.getElementById("topCostumerChart"));
      topCostumerChart.draw(topCostumerView, topCostumerOptions);

      //Grafico TOP10 Produtos
      //Grafico TOP10 Produtos
      //Grafico TOP10 Produtos
      var topProductData = google.visualization.arrayToDataTable([
        ['Nome do Produto', 'Vendas', 'Receita', {
          role: 'annotation'
        }],
        <?php foreach ($top_produtos as $ProductCode => $data) {
          echo "['{$data['ProductDescription']}', {$data['total_vendido']}, {$data['total_dinheiro']}, '{$data['total_dinheiro']} {$data['total_vendido']}'],";
        } ?>
      ]);

      var topProductView = new google.visualization.DataView(topProductData);
      topProductView.setColumns([0, 2, 1, {
        calc: "stringify",
        sourceColumn: 1,
        type: "string",
        role: "annotation"
      }]);


      var topProductOptions = {
        title: "Top 10 Produtos Por Receita e Vendas Totais",
        width: 700,
        height: 500,
        chartArea: {
          left: 80,
          top: 80,
          right: 80,
          bottom: 80
        },
        hAxis: {
          title: 'Receita',
          minValue: 0,
          textStyle: {
            fontSize: 12
          }
        },
        vAxis: {
          title: 'Nome do Produto',
          textStyle: {
            fontSize: 12
          }
        },
        bar: {
          groupWidth: '70%'
        },
        legend: {
          position: "none"
        },
        annotations: {
          textStyle: {
            fontSize: 12,
            bold: true
          }
        }
      };

      formatter.format(topProductData, 2);


      var topProductChart = new google.visualization.BarChart(document.getElementById("topProductChart"));
      topProductChart.draw(topProductView, topProductOptions);


      //Grafico Horas
      //Grafico Horas
      //Grafico Horas
      var horasChartData = google.visualization.arrayToDataTable(<?php echo json_encode($HorasArray); ?>);

      var horasChartOptions = {
        title: "Total de Produtos e Receita por Hora",
        curveType: "function",
        legend: {
          position: "bottom"
        },
        hAxis: {
          title: 'Horas',
          minValue: 0,
          textStyle: {
            fontSize: 12
          }
        },
        vAxis: {
          title: 'Produtos Vendidos e Receita (€)',
          textStyle: {
            fontSize: 12
          }
        },
      };
      formatter.format(horasChartData, 2);

      var horasChart = new google.visualization.LineChart(document.getElementById("horasChart_div"));
      horasChart.draw(horasChartData, horasChartOptions);

      //Grafico Dias
      //Grafico Dias
      //Grafico Dias
      var diasChartData = google.visualization.arrayToDataTable(<?php echo json_encode($DiasArray); ?>);

      var diasChartOptions = {
        title: "Total de Produtos e Receita por Dia",
        curveType: "function",
        legend: {
          position: "bottom"
        },
        hAxis: {
          title: 'Dias',
          minValue: 0,
          textStyle: {
            fontSize: 12
          }
        },
        vAxis: {
          title: 'Produtos Vendidos e Receita (€)',
          textStyle: {
            fontSize: 12
          }
        },
      };
      formatter.format(diasChartData, 2);
      var diasChart = new google.visualization.LineChart(document.getElementById("diasChart_div"));
      diasChart.draw(diasChartData, diasChartOptions);


    }
  </script>
  <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
  <!--begin::Theme mode setup on page load-->
  <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
      if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
        themeMode =
          document.documentElement.getAttribute("data-bs-theme-mode");
      } else {
        if (localStorage.getItem("data-bs-theme") !== null) {
          themeMode = localStorage.getItem("data-bs-theme");
        } else {
          themeMode = defaultThemeMode;
        }
      }
      if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ?
          "dark" :
          "light";
      }
      document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
  </script>
  <!--end::Theme mode setup on page load-->
  <!--begin::App-->
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
      <!--begin::Header-->
      <?php include('includes/header.php'); ?>
      <!--end::Header-->
      <!--begin::Wrapper-->
      <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <!--begin::Sidebar-->
        <?php include('includes/sidebar.php'); ?>
        <!--end::Sidebar-->
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <!--begin::Content wrapper-->
          <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar pt-7 pt-lg-10">
              <!--begin::Toolbar container-->
              <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                  <!--begin::Page title-->
                  <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">
                      <?php echo $CompanyName; ?>
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                      <!--begin::Item-->
                      <li class="breadcrumb-item text-muted">
                        <a href="../../demo38/dist/index.html" class="text-muted text-hover-primary"><?php echo $CompanyAddressDetail ?></a>
                      </li>
                      <!--end::Item-->
                      <!--begin::Item-->
                      <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                      </li>
                      <!--end::Item-->
                      <!--begin::Item-->
                      <li class="breadcrumb-item text-muted"><?php echo $CompanyCity ?></li>
                      <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                  </div>
                  <!--end::Page title-->
                </div>
                <!--end::Toolbar wrapper-->
              </div>
              <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
              <!--begin::Content container-->
              <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10">
                  <div class="col-xxl-6 mb-5 mb-xl-10">
                    <!--begin::Maps widget 1-->
                    <div class="card card-flush h-md-100">
                      <!--begin::Header-->
                      <div class="card-header pt-7" style="display: flex; justify-content: space-between; align-items: center;">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                          <span class="card-label fw-bold text-dark">Vendas de Produtos e Receita por Dias</span>
                          <span class="text-gray-400 pt-2 fw-semibold fs-6">Gráfico de Produtos e Receita Diária</span>

                        </h3>
                        <a href="faturacao-dias" class="text-primary opacity-75-hover fs-6 fw-bold">Ver toda a Faturação por Dias
                          <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                          <span class="svg-icon svg-icon-3 svg-icon-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                              <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                          </span>
                          <!--end::Svg Icon--></a>
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body d-flex flex-center">
                        <!--begin::Map container-->
                        <div id="diasChart_div" style="width: 1400px; height: 500px"></div>
                        <!--end::Map container-->
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Maps widget 1-->
                  </div>
                  <div class="col-xxl-6 mb-5 mb-xl-10">
                    <!--begin::Maps widget 1-->
                    <div class="card card-flush h-md-100">
                      <!--begin::Header-->
                      <div class="card-header pt-7" style="display: flex; justify-content: space-between; align-items: center;">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                          <span class="card-label fw-bold text-dark">Vendas de Produtos e Receita por Horas</span>
                          <span class="text-gray-400 pt-2 fw-semibold fs-6">Gráfico de Produtos e Receita por Horas</span>
                        </h3>
                        <a href="faturacao-horas" class="text-primary opacity-75-hover fs-6 fw-bold">Ver toda a Faturação por Horas
                          <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                          <span class="svg-icon svg-icon-3 svg-icon-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                              <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                          </span>
                          <!--end::Svg Icon--></a>
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body d-flex flex-center">
                        <!--begin::Map container-->
                        <div id="horasChart_div" style="width: 1400px; height: 500px;"></div>
                        <!--end::Map container-->
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Maps widget 1-->
                  </div>
                </div>
                <div class="row g-5 g-xl-10">
                  <div class="col-xxl-6 mb-5 mb-xl-10">
                    <!--begin::Maps widget 1-->
                    <div class="card card-flush h-md-100">
                      <!--begin::Header-->
                      <div class="card-header pt-7" style="display: flex; justify-content: space-between; align-items: center;">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                          <span class="card-label fw-bold text-dark">Vendas de Produtos e Receita por Dias da Semana</span>
                          <span class="text-gray-400 pt-2 fw-semibold fs-6">Gráfico de Produtos e Receita Diária</span>

                        </h3>
                        <a href="faturacao-dias" class="text-primary opacity-75-hover fs-6 fw-bold">Ver toda a Faturação por Dias da Semana
                          <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                          <span class="svg-icon svg-icon-3 svg-icon-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                              <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                          </span>
                          <!--end::Svg Icon--></a>
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body d-flex flex-center">
                        <!--begin::Map container-->
                        <div id="table_div" style="width: 1400px; height: 500px"></div>
                        <!--end::Map container-->
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Maps widget 1-->
                  </div>
                  <div class="col-xxl-6 mb-5 mb-xl-10">
                    <!--begin::Maps widget 1-->
                    <div class="card card-flush h-md-100">
                      <!--begin::Header-->
                      <div class="card-header pt-7" style="display: flex; justify-content: space-between; align-items: center;">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                          <span class="card-label fw-bold text-dark">Valor Gasto Medio e Total por Cliente</span>
                          <span class="text-gray-400 pt-2 fw-semibold fs-6">Valor Gasto Medio Total: <?php echo floatval($MediaGasto) . "€"; ?></span>

                        </h3>
                        <a href="faturacao-dias" class="text-primary opacity-75-hover fs-6 fw-bold">Ver o valor Medio de Todos os Clientes
                          <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                          <span class="svg-icon svg-icon-3 svg-icon-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                              <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                          </span>
                          <!--end::Svg Icon--></a>
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body d-flex flex-center">
                        <!--begin::Map container-->
                        <div id="gastoCliente_div" style="width: 1400px; height: 500px"></div>
                        <!--end::Map container-->
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Maps widget 1-->
                  </div>

                </div>
                <div class="row g-5 g-xl-10">
                  <div class="col-xxl-6 mb-5 mb-xl-10">
                    <!--begin::Maps widget 1-->
                    <div class="card card-flush h-md-100">
                      <!--begin::Header-->
                      <div class="card-header pt-7" style="display: flex; justify-content: space-between; align-items: center;">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                          <span class="card-label fw-bold text-dark">Faturação Total: <?php echo $TotalCredit ?> €</span>
                          <span class="text-gray-400 pt-2 fw-semibold fs-6">Gráfico da Faturação Diária</span>

                        </h3>
                        <a href="faturacao" class="text-primary opacity-75-hover fs-6 fw-bold">Ver toda a Faturação
                          <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                          <span class="svg-icon svg-icon-3 svg-icon-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                              <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                          </span>
                          <!--end::Svg Icon--></a>
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body d-flex flex-center">
                        <!--begin::Map container-->
                        <div id="chartReceitaDiaria" style="width: 1400px; height: 500px"></div>
                        <!--end::Map container-->
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Maps widget 1-->
                  </div>
                  <!--end::Col-->
                  <div class="col-xxl-6 mb-5 mb-xl-10">
                    <!--begin::Maps widget 1-->
                    <div class="card card-flush h-md-100">
                      <!--begin::Header-->
                      <div class="card-header pt-7" style="display: flex; justify-content: space-between; align-items: center;">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                          <span class="card-label fw-bold text-dark">Total de Produtos Vendidos: <?php echo $totalProducts ?></span>
                          <span class="text-gray-400 pt-2 fw-semibold fs-6">Gráfico da Quantidade de Produtos vendidos diariamente</span>
                        </h3>
                        <a href="faturacao" class="text-primary opacity-75-hover fs-6 fw-bold">Ver todos os Produtos
                          <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                          <span class="svg-icon svg-icon-3 svg-icon-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                              <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                          </span>
                          <!--end::Svg Icon--></a>
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body d-flex flex-center">
                        <!--begin::Map container-->
                        <div id="chartProdutosDiariosArray" style="width: 1400px; height: 500px"></div>
                        <!--end::Map container-->
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Maps widget 1-->
                  </div>
                  <!--end::Col-->
                </div>
                <div class="row g-5 g-xl-10">
                  <div class="col-xxl-6 mb-5 mb-xl-10">
                    <!--begin::Maps widget 1-->
                    <div class="card card-flush h-md-100">
                      <!--begin::Header-->
                      <div class="card-header pt-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                          <span class="card-label fw-bold text-dark">Total de Clientes: <?php echo $totalClientes ?></span>
                          <span class="text-gray-400 pt-2 fw-semibold fs-6">Gráfico do TOP 10 Clientes</span>
                        </h3>
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body d-flex flex-center">
                        <!--begin::Map container-->
                        <div id="topCostumerChart" style="width: 1400px; height: 500px;"></div>
                        <!--end::Map container-->
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Maps widget 1-->
                  </div>
                  <div class="col-xxl-6 mb-5 mb-xl-10">
                    <!--begin::Maps widget 1-->
                    <div class="card card-flush h-md-100">
                      <!--begin::Header-->
                      <div class="card-header pt-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                          <span class="card-label fw-bold text-dark">Total de Produtos: <?php echo $totalProdutos ?></span>
                          <span class="text-gray-400 pt-2 fw-semibold fs-6">Gráfico do TOP 10 Produtos</span>
                        </h3>
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body d-flex flex-center">
                        <!--begin::Map container-->
                        <div id="topProductChart" style="width: 1400px; height: 500px;"></div>
                        <!--end::Map container-->
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Maps widget 1-->
                  </div>
                </div>
              </div>
              <!--end::Content container-->
            </div>
            <!--end::Content-->
          </div>
          <!--end::Content wrapper-->
          <?php include('includes/footer.php'); ?>
        </div>
        <!--end:::Main-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Page-->
  </div>
  <!--end::App-->
  <!--begin::Javascript-->
  <script>
    var hostUrl = "assets/";
  </script>
  <!--begin::Global Javascript Bundle(mandatory for all pages)-->
  <script src="assets/plugins/global/plugins.bundle.js"></script>
  <script src="assets/js/scripts.bundle.js"></script>
  <!--end::Global Javascript Bundle-->
  <!--begin::Vendors Javascript(used for this page only)-->
  <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
  <script src="assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
  <!--end::Vendors Javascript-->
  <!--begin::Custom Javascript(used for this page only)-->
  <script src="assets/js/widgets.bundle.js"></script>
  <script src="assets/js/custom/widgets.js"></script>
  <script src="assets/js/custom/apps/chat/chat.js"></script>
  <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
  <script src="assets/js/custom/utilities/modals/create-campaign.js"></script>
  <script src="assets/js/custom/utilities/modals/users-search.js"></script>
  <!--end::Custom Javascript-->
  <!--end::Javascript-->
</body>
<!--end::Body-->

</html>