/**
 * Created by sr199 on 12/23/2018.
 */



/**
 * get params from url
 * @param name
 * @returns {string}
 * @constructor
 */
function getRequestFromUrl(name) {
    var url = location.search;
    var varName = "";
    var varVal = "";
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for(var i = 0; i < strs.length; i ++) {
            var temp = strs[i].split("=");
            varName = temp[0];
            if(name == varName){
                varVal = temp[1];
            }
        }
    }
    return varVal;
}

function $(id){
    return document.getElementById(id);
}

function getXmlHttpObject(){
    var xmlHttpObject;
    try {
        // Firefox,Opera,Safari
        xmlHttpObject = new XMLHttpRequest();
    }catch (e){
        //Internet Explorer
        try{
            xmlHttpObject = new ActiveXObject("Maxml2.XMLHTTP");
        } catch (e){
            xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttpObject;
}

function getDate(){
    var date = new Date();
    var dateF = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " "
        + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
    return dateF;
}