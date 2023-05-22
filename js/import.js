const form = document.querySelector("#xml-form");
form
  .addEventListener("submit", (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();
    xhr.open(form.method, form.action);
    xhr.setRequestHeader("Accept", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState !== XMLHttpRequest.DONE) return;
      if (xhr.status === 200) {
        console.log(xhr.response);
        if (xhr.response == "successo") {
          //caso o php retornce sucesso (conta criada)
          Swal.fire({
            text: "Dados Importados com sucesso",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "OK, entendi!",
            customClass: {
              confirmButton: "btn btn-primary",
            },
          }).then(function (result) {
            if (result.isConfirmed) {
              form.reset(); // reset form
              //form.submit();

              //form.submit(); // submit form
              var redirectUrl = form.getAttribute("data-kt-redirect-url"); //envia para a pagina login
              if (redirectUrl) {
                location.href = redirectUrl;
              }
            }
          });
        } else if (xhr.response == "No FileDifferent File Version") {
          Swal.fire({
            text: "Nenhum Ficheiro Inserido",
            icon: "info",
            buttonsStyling: false,
            confirmButtonText: "Ok, Entendi!",
            customClass: {
              confirmButton: "btn btn-primary",
            },
          });
        } else if (xhr.response == "Not Supported FileDifferent File Version") {
          Swal.fire({
            text: "O Ficheiro Inserido não é um xml Válido!",
            icon: "info",
            buttonsStyling: false,
            confirmButtonText: "Ok, Entendi!",
            customClass: {
              confirmButton: "btn btn-primary",
            },
          });
        } else if (xhr.response == "Different File Version") {
          Swal.fire({
            text: "A Versão do Ficheiro SAFT não é compativél!",
            icon: "info",
            buttonsStyling: false,
            confirmButtonText: "Ok, Entendi!",
            customClass: {
              confirmButton: "btn btn-primary",
            },
          });
        } else if (xhr.response == "duplicado") {
          Swal.fire({
            text: "O ficheiro SAFT já existe na base de dados!",
            icon: "info",
            buttonsStyling: false,
            confirmButtonText: "Exportar os Dados!",
            customClass: {
              confirmButton: "btn btn-primary",
            },
          }).then(function (result) {
            if (result.isConfirmed) {
              form.reset(); // reset form
              //form.submit();

              //form.submit(); // submit form
              var redirectUrl = form.getAttribute("data-kt-redirect-url"); //envia para a pagina login
              if (redirectUrl) {
                location.href = redirectUrl;
              }
            }
          });
        } else {
          Swal.fire({
            text: "Ocorreu um erro!",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, Entendi!",
            customClass: {
              confirmButton: "btn btn-primary",
            },
          });
        }
      } else {
        console.error(xhr.response);
      }
    };
    xhr.send(formData);
  })
  .catch((error) => {
    console.error(error);
  });

