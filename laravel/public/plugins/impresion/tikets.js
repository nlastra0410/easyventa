var dropDownImpresoras = document.getElementById("nombreImpresoras");
var apiRouter = "http://127.0.0.1:5656/";

const obtenerImpresoras = () =>{
    PrinterEscPos.getPrinters().then(response=>{
        if(response.status == "OK"){
            response.listPrinter.forEach(namePrinter => {
                const option =document.createElement("option");
                option.value = option.text = namePrinter;
                dropDownImpresoras.appendChild(option);
            });
        }
    });
};

const imprimeTicket = () =>{
    var impresora = new PrinterEscPos(apiRouter);
    impresora.setText("hola");
    impresora.setBarcode("56");
    impresora.setQr("9898");
    impresora.setConfigure("center",font="a",true);
    impresora.setText("LETRAS NEGRITAS Y CE");
    impresora.printerIn(dropDownImpresoras.value);
};

obtenerImpresoras();