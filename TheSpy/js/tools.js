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


function checkIllegalLogin(location){
    var HttpXmlObject = getXmlHttpObject();
    if (HttpXmlObject) {
        var url = "../Controller/CheckLegalityController.php";
        var data = "location=" + location;
        HttpXmlObject.open("post", url, true);
        HttpXmlObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        HttpXmlObject.onreadystatechange = function () {
            if (HttpXmlObject.readyState == 4) {
                if (HttpXmlObject.status == 200) {
                    var info = HttpXmlObject.responseText;
                    var info_obj = eval("(" + info + ")");
                    var isLegal = info_obj.errno;
                    if(isLegal == 1){
                        window.location.href = "../Login.html"
                    }
                }
            }
        };
        HttpXmlObject.send(data);
    }
}


/**
 *
 * @param userId
 * @param userName
 * @param content
 * @param time
 * @param imgPath
 * @param position
 * @returns {string}
 */
function htmlDisplayMess(userId,userName,content,time,imgPath,position){

    var className = "";
    var textDiv = "";
    if(position == "left") {
        className = "player";
        textDiv = "<div style='text-align: left;margin-top: 0.1%;font-size:9px'>";
    }else{
        className = "self";
        textDiv = "<div style='text-align: right;margin-top: 0.1%;font-size:9px'>";
    }

    var updateText = "<li>";
    updateText += "<p class=\"system\"><span>";
    updateText += time;
    updateText += "</span></p>";
    updateText += "<div>";
    updateText += "<div id=\"pt_";
    updateText += userId;
    updateText += "\" class=\"main\">";
    updateText += "<img class=\"";
    updateText += className;
    updateText += "\"width=\"12%\" src=\"";
    updateText += imgPath;
    updateText += "\">";
    updateText += textDiv;
    updateText += userName;
    updateText += "</div>";
    updateText += "<div class="+ className +"_text>";
    updateText += content;
    updateText += "</div>";
    updateText += "</div>";
    updateText += "</div>";
    updateText += "</li>";

    /*var updateText = "<li>";
    updateText += "<p class=\"system\"><span>";
    updateText += time;
    updateText += "</span></p>";
    updateText += "<div>";
    updateText += "<div style='text-align: left;margin-top: 0.1%'>";
    updateText += userName;
    updateText += "</div>";
    updateText += "<div id=\"pt_";
    updateText += userId;
    updateText += "\" class=\"main\">";
    updateText += "<img class=\"player\" width=\"10%\" src=\"";
    updateText += imgPath;
    updateText += "\">";
    updateText += "<div class=\"player_text\">";
    updateText += content;
    updateText += "</div>";
    updateText += "</div>";
    updateText += "</div>";
    updateText += "</li>";*/
    return updateText;
}


function expConversion(exp){
    var level= 10;
    for(var i = 1;i <10;i++){
        var rule = 2 ^ i;
        if(rule > exp){
            level = i;
            break;
        }
    }
    return level;
}

