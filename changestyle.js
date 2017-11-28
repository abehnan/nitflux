function setCookie(cTheme, cValue, cExpiry)
{
    var d = new Date();
    d.setTime(d.getTime() + (cExpiry*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cTheme + "=" + cValue + ";" + expires + ";path=/";
    //document.cookie = cTheme + "=" + cValue + ";" + expires + ";path=/";
}

function getCookie(cname)
{
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie()
{
    var user=getCookie("theme");
   
    if (user == "dark")
    {
        switchDark();
    }
    else if(user == "light")
    { switchLight();}
    else {switchLight();}
}

function switchDark()
{
    document.body.style.backgroundColor="#202020";
    //Change color of top login bar 
    document.getElementById('loginbar').style.backgroundColor="#202020";
    document.getElementById('loginbar').style.color="#99ccff";
    
    // login links
    var loginlinks = document.getElementsByClassName('loginlink')
    for(var i = 0, length = loginlinks.length; i < length; i++) 
    {
        loginlinks[i].style.color="#ffb3b3";
    }
    
    // theme buttons
    var buttons = document.getElementsByClassName('mybutton');
    for(var i = 0, length = buttons.length; i < length; i++) 
    {
        buttons[i].style.color="#ffb3b3";
        buttons[i].style.backgroundColor="#606060";
    }

    // title bar
    document.getElementById('titlebar').style.backgroundColor="#606060";
    document.getElementById('titlebar').style.color="#99ccff";
    
    // menu bar
    document.getElementById('menubar').style.backgroundColor="#A0A0A0";

    // menu links 
    var titlebars=document.getElementsByClassName('menulink');
    for(var i = 0, length = titlebars.length; i < length; i++) 
    {
        titlebars[i].style.color="#ffb3b3";
    }
    
    // main
    var bodytext = document.getElementsByClassName('main');
    for(var i = 0, length = bodytext.length; i<length; i++)
    {
        bodytext[i].style.backgroundColor="#202020";
        bodytext[i].style.color="#99ccff";
    }

    // var body = document.getElementsByClassName('body');
    // for(var i = 0, length = body.length; i<length; i++)
    // {
    //     body[i].style.backgroundColor="#202020";
    //     body[i].style.color="#99ccff";
    // }
   


    // set the cookie 
    setCookie("theme", "dark", 2);

    document.style.backgroundColor="#202020";
};

function switchLight()
{
    document.body.style.backgroundColor="#fff2e6";
    setCookie("theme", "light", 2);

    // login bar
    document.getElementById('loginbar').style.backgroundColor="rgb(167, 78, 0)";
    document.getElementById('loginbar').style.color="white";

    // login links
    var loginlinks = document.getElementsByClassName('loginlink')
    for(var i = 0, length = loginlinks.length; i < length; i++) 
    {
        loginlinks[i].style.color="white";
    }
    
    // theme buttons
    var buttons = document.getElementsByClassName('mybutton');
    for(var i = 0, length = buttons.length; i < length; i++) 
    {
        buttons[i].style.color="white";
        buttons[i].style.backgroundColor="rgb(230, 136, 59)";
    }

    // title bar
    document.getElementById('titlebar').style.backgroundColor="rgb(230, 136, 59)";
    document.getElementById('titlebar').style.color="white";
    
    // menu bar
    document.getElementById('menubar').style.backgroundColor="rgb(218, 218, 218)";

    // menu buttons
    var titlebars=document.getElementsByClassName('menulink');
    for(var i = 0, length = titlebars.length; i < length; i++) 
        {
            titlebars[i].style.color="black";
        }
    
    // main
    var bodytext = document.getElementsByClassName('main');
    for(var i = 0, length = bodytext.length; i<length; i++)
    {
        bodytext[i].style.backgroundColor="#fff2e6";
        bodytext[i].style.color="black";
    }

    var body = document.getElementsByClassName('body');
    for(var i = 0, length = body.length; i<length; i++)
    {
        body[i].style.backgroundColor="#fff2e6";
        body[i].style.color="black";
    }
    
    /*Main
    var main = document.getElementsByClassName('main');
    {
        //main[i].style.backgroundColor="white";
        main[i].style.color="black";
    }*/
}
