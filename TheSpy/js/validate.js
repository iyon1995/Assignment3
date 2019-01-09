/**
 * Created by sr199 on 1/9/2019.
 */

/**
 * check validation of login password
 * @returns {string}
 */
function comparePassword() {
    var fpassword = document.getElementById("fpassword").value;
    var spassword = document.getElementById("spassword").value;
    var errMess = "";
    if(fpassword == ""){
        errMess = "the passwords can not be empty!";
    }else if(fpassword.length < 8 || fpassword.length > 16){
        errMess = "the length of passwords must be from 8 to 16";
    }else if(fpassword != spassword){
        errMess = "the passwords are not the same!";
    }
    return errMess;
}

/**
 * check validation of email
 * @returns {string}
 */
function checkEmail() {
    var email = document.getElementById("email");
    var regExp = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    var errMess = "";
    if (email.value == "") {
        errMess = "please input email address!";
    }else if(!regExp.test(email.value)){
        errMess = "the email address is not valid!";
    }
    return errMess;
}

function checkRoomId(roomId){
    var errMess = "";
    if(roomId == ""){
        errMess = "please enter a room id to search room!";
    }else if(isNaN(roomId)){
        errMess = "room id only allow number!";
    }
    return errMess;
}

function checkContent(content){
    if(fpassword.length > 100){
        errMess = "the length of message can not larger than 100 character";
    }
}