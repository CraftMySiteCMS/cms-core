//Darkmode file

let darkMode = localStorage.getItem('darkMode');
const darkModeToggle = document.querySelector('#darkModeToggle');

//Here we check if the darkmode is enabled
const enableDarkMode = () => {
    //Add the classes
    document.body.classList.add('dark-mode');
    document.getElementById('navbarTop').classList.add('darkMode-navbar', 'navbar-dark');
    document.getElementById('navbarTop').classList.remove('navbar-light');

    localStorage.setItem('darkMode', 'enabled');
};

//Here we check if the darkmode is disabled
const disableDarkMode = () => {
    //Remove the classes
    document.body.classList.remove('dark-mode');
    document.getElementById('navbarTop').classList.remove('darkMode-navbar', 'navbar-dark');
    document.getElementById('navbarTop').classList.add('navbar-light');

    localStorage.setItem('darkMode', null);
};

if (darkMode === 'enabled'){
    enableDarkMode();
}

darkModeToggle.addEventListener('click', () => {
    darkMode = localStorage.getItem('darkMode');
    if (darkMode !== 'enabled'){
        enableDarkMode();
    } else{
        disableDarkMode();
    }
})