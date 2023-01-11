<script>
  
    if (localStorage.getItem('theme') == 'dark') {
        setDarkMode();
        if (document.getElementById('chkbox-dark').checked) {
            localStorage.setItem('chkbox-dark', true)      
        }
    }else{
        $('.mode-icon').addClass('fa-regular fa-moon'); 
    }

    function setDarkMode() {

        const body = document.querySelector('body'),
                     //sidebar = body.querySelector('nav'),
                     //toggle = body.querySelector(".toggle"),
                    // searchBtn = body.querySelector(".search-box"),
                    // modeSwitch = body.querySelector(".toggle-switch"),
                     modeText = body.querySelector(".mode-text");

        let isDark = document.body.classList.toggle('darkmode');
        if (isDark) {
            setDarkMode.checked = true;
            localStorage.setItem('theme', 'dark');
            document.getElementById('chkbox-dark').setAttribute('checked', 'checked');
            modeText.innerText = "Light mode";
            $('.mode-icon').addClass('fa-regular fa-sun');
            //$('.table').addClass('table-dark');
            $("#lgcLogo").attr("src","<?php echo $url; ?>img/LausGroupWhite.png");
        } else {
            setDarkMode.checked = true;
            localStorage.removeItem('theme', 'dark');
            modeText.innerText = "Dark mode";
            $('.mode-icon').removeClass('fa-regular fa-sun');
            $('.mode-icon').addClass('fa-regular fa-moon');
            //$('.table').removeClass('table-dark');
            $("#lgcLogo").attr("src","<?php echo $url; ?>img/LausGroup.png");
        }
    }
 
        

    // const body = document.querySelector('body'),
    //       sidebar = body.querySelector('nav'),
    //       toggle = body.querySelector(".toggle"),
    //       searchBtn = body.querySelector(".search-box"),
    //       modeSwitch = body.querySelector(".toggle-switch"),
    //       modeText = body.querySelector(".mode-text");


    // toggle.addEventListener("click" , () =>{
    //     sidebar.classList.toggle("close");
    // })

    // searchBtn.addEventListener("click" , () =>{
    //     sidebar.classList.remove("close");
    // })

    // modeSwitch.addEventListener("click" , () =>{
    //     body.classList.toggle("dark");
        
    //     if(body.classList.contains("dark")){
    //         modeText.innerText = "Light mode";
    //     }else{
    //         modeText.innerText = "Dark mode";
            
    //     }
    // });

</script>