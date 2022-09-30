function testFunc() {
    alert("test");
}
function getCode() {
    //document.getElementById("btnGetCode").innerHTML = "";
    document.getElementById("inputPhone").disabled = true;
    document.getElementById("btnGetCode").disabled = true;

    var str = document.getElementById("inputPhone").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("authform").innerHTML = this.responseText;
        }
    }

    xmlhttp.open("GET", "getCode.php?phone="+ encodeURIComponent(str), true);
    xmlhttp.send()

}


function registerCode() {
    //document.getElementById("btnGetCode").innerHTML = "";
    document.getElementById("inputCode").disabled = true;
    document.getElementById("btnRegisterCode").disabled = true;

    var str = document.getElementById("inputCode").value;
    var phone = document.getElementById("frmPhone").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("authform").innerHTML = this.responseText;
        }
    }

    xmlhttp.open("GET", "registerCode.php?code="+ str + '&phone=' + encodeURIComponent(phone), true);
    xmlhttp.send()

}

function getProducts() {
    //document.getElementById("btnGetCode").innerHTML = "";
    document.getElementById("btnGetProducts").disabled = true;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("authform").innerHTML = this.responseText;
        }
    }

    xmlhttp.open("GET", "getProducts.php", true);
    xmlhttp.send()

}

function getVariants() {
    //document.getElementById("btnGetCode").innerHTML = "";
    document.getElementById("btnGetVariants").disabled = true;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("authform").innerHTML = this.responseText;
        }
    }
    var str = document.getElementById("products").value;

    xmlhttp.open("GET", "getVariants.php?uri=" + encodeURIComponent(str), true);
    xmlhttp.send()

}

function selectVariant() {

    var variants = document.getElementsByName('variant');
    var variants_value;

    for(var i = 0; i < rates.length; i++){
        if(variants[i].checked){
            variants_value = variants[i].value;
        }
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("authform").innerHTML = this.responseText;
        }
    }
    var str = document.getElementById("products").value;

    xmlhttp.open("GET", "getVariants.php?uri=" + encodeURIComponent(str), true);
    xmlhttp.send()

}

function saveConfig() {
    // Get variant
    var variants = document.getElementsByName('variant');
    var variants_value;

    for(var i = 0; i < variants.length; i++){
        if(variants[i].checked){
            variants_value = variants[i].value;
        }
    }

    // Get Car
    var cars = document.getElementsByName('car');
    var cars_value;

    for(var i = 0; i < cars.length; i++){
        if(cars[i].checked){
            cars_value = cars[i].value;
        }
    }


    alert("variant: " + variants_value + " car: " + cars_value);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("authform").innerHTML = this.responseText;
        }
    }
    var str = document.getElementById("products").value;

    xmlhttp.open("GET", "saveConfig.php?plate=" +  encodeURIComponent(cars_value) + "&uri=" + encodeURIComponent(variants_value), true);
    xmlhttp.send()
}