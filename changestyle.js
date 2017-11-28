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
    setCookie("theme", "dark", 1);
    document.body.style.backgroundColor="#202020";
    //Change color of top login bar 
    document.getElementById('loginbar').style.backgroundColor="#202020";
    document.getElementById('loginbar').style.color="#99ccff";
    
    var loginlinks = document.getElementsByClassName('loginlink')
    for(var i = 0, length = loginlinks.length; i < length; i++) 
    {
        loginlinks[i].style.color="#ffb3b3";
    }
    
    //Change colors of buttons

    var buttons = document.getElementsByClassName('mybutton');
    for(var i = 0, length = buttons.length; i < length; i++) 
    {
        buttons[i].style.color="#ffb3b3";
        buttons[i].style.backgroundColor="#606060";
    }
   

    //Change colors of title bars
    document.getElementById('titlebar').style.backgroundColor="#606060";
    document.getElementById('titlebar').style.color="#99ccff";
    
    //Menu
    document.getElementById('menubar').style.backgroundColor="#A0A0A0";
    var titlebars=document.getElementsByClassName('menulink');
    for(var i = 0, length = titlebars.length; i < length; i++) 
        {
            titlebars[i].style.color="#ffb3b3";
        }
    
    // For the Body    
    var bodytitles = document.getElementsByClassName('blogtitle');
    for(var i = 0, length = bodytitles.length; i<length; i++)
    {
        bodytitles[i].style.backgroundColor="#606060";
        bodytitles[i].style.color="#ffb3b3";
    }
    
    var bodytext = document.getElementsByClassName('blog');
    for(var i = 0, length = bodytext.length; i<length; i++)
    {
        bodytext[i].style.backgroundColor="#202020";
        bodytext[i].style.color="#99ccff";
    }

        // this breaks the theme switch
    // var bloglinks = document.getElementsByClassName('bloglink');
    // for (var i = 0, length = titlebars.length; i < length; i++) {
    //     bloglinks[i].style.color = "#ffb3b3";
    // }

    //Main
    var main = document.getElementsByClassName('main');
    {
        main[i].style.backgroundColor="#202020";
        main[i].style.color="#99ccff";
    }
};

function switchLight()
{
    setCookie("theme", "light", 1);
    document.body.style.backgroundColor="#fff2e6";
    //Change color of top login bar 
    document.getElementById('loginbar').style.backgroundColor="rgb(167, 78, 0)";
    document.getElementById('loginbar').style.color="white";
    var loginlinks = document.getElementsByClassName('loginlink')
    for(var i = 0, length = loginlinks.length; i < length; i++) 
    {
        loginlinks[i].style.color="white";
    }
    
    //Change colors of buttons
    var buttons = document.getElementsByClassName('mybutton');
    for(var i = 0, length = buttons.length; i < length; i++) 
    {
        buttons[i].style.color="white";
        buttons[i].style.backgroundColor="rgb(230, 136, 59)";
    }

    //Title
    document.getElementById('titlebar').style.backgroundColor="rgb(230, 136, 59)";
    document.getElementById('titlebar').style.color="white";
    
    //Menu
    document.getElementById('menubar').style.backgroundColor="rgb(218, 218, 218)";
    var titlebars=document.getElementsByClassName('menulink');
    for(var i = 0, length = titlebars.length; i < length; i++) 
        {
            titlebars[i].style.color="black";
        }

    //Body    
    var bodytitles = document.getElementsByClassName('blogtitle');
    for(var i = 0, length = bodytitles.length; i<length; i++)
    {
        bodytitles[i].style.backgroundColor="#ffd6b3";
        bodytitles[i].style.color="black";
    }
    

    var bodytext = document.getElementsByClassName('blog');
    for(var i = 0, length = bodytext.length; i<length; i++)
    {
        bodytext[i].style.backgroundColor="#fff2e6";
        bodytext[i].style.color="black";
    }

    // bloglinks
    // var bloglinks = document.getElementsByClassName('bloglink');
    // for (var i = 0, length = bodytext.length; i < length; i++) {
    //     bloglinks[i].style.color = "black";
    // }
    
    //Main
    var main = document.getElementsByClassName('main');
    {
        main[i].style.backgroundColor ="#fff2e6";
        main[i].style.color="black";
    }
}
