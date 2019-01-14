/**
 * Created by sr199 on 1/9/2019.
 */

/**
 * check validation of login password
 * @returns {string}
 */
function comparePassword(fpassword,spassword) {
    var errMess = "";
    if(fpassword == ""){
        errMess = "The passwords can not be empty!";
    }else if(fpassword.length < 8 || fpassword.length > 16){
        errMess = "The length of passwords must be from 8 to 16";
    }else if(fpassword != spassword){
        errMess = "The passwords are not the same!";
    }
    return errMess;
}

/**
 * check validation of email
 * @returns {string}
 */
function checkEmail(email) {
    var regExp = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    var errMess = "";
    if (email == "") {
        errMess = "Please input email address!";
    }else if(!regExp.test(email)){
        errMess = "The email address is not valid!";
    }
    return errMess;
}


function checkUserName(userName){
    var errMess = "";
    if(userName == ""){
        errMess = "The userName can not be empty!";
    }else if(userName.length > 18){
        errMess = "The length of userName must be less than 18!!!";
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