const ctx =
    document.getElementById("myChart");

let chartCorrente = null;

function caricaGrafico(tipo){

    fetch("../includes/get_grafici.php?tipo=" + tipo)

    .then(response => response.json())

    .then(dati => {

        if(chartCorrente != null){

            chartCorrente.destroy();
        }

        let tipoGrafico = "bar";

        if(tipo == "mezzi"){

            tipoGrafico = "pie";
        }

        chartCorrente = new Chart(ctx, {

            type: tipoGrafico,

            data: {

                labels: dati.labels,

                datasets: [{

                    label: "Statistiche",

                    data: dati.data,

                    borderWidth: 1
                }]
            },

            options: {

                responsive: true
            }
        });
    })

    .catch(error => {

        console.log(error);
    });
}