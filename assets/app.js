/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../node_modules/mvp.css/mvp.css';
import './styles/app.scss';

import Cookies from 'js-cookie';

const inputElement  = document.createElement('input');
inputElement.setAttribute('name','value');
inputElement.setAttribute('placeholder','2e0de186-9731-11ec-93ee-91efcced1f62');const selectNamespace = document.querySelector('select[name="namespace"]');
if (selectNamespace !== null) {
    selectNamespace.addEventListener('change', evt => {
        const element = evt.target;
        let value;
        if(element.selectedOptions.length > 0){
            value = element.selectedOptions[0]?.value;
        }else{
            value = null;
        }
        if(value === null){
            return undefined;
        }
        const parentElement = element.parentElement;

        if (value !== 'CUSTOM') {
            parentElement.removeChild(inputElement);
            return undefined;
        }

        parentElement.appendChild(inputElement);
    });
}
const changeToLight = () => {
    const bodyElement = document.querySelector('body');
    bodyElement.classList.remove('darkMode');
    document.querySelectorAll('.color-changer').forEach(element => {
        element.innerText = 'Dark Mode';
    });
    Cookies.set('COLOR_MODE', 'light')
};
const changeToDark = () => {
    const bodyElement = document.querySelector('body');
    if(!bodyElement.classList.contains('darkMode')){
        bodyElement.classList.add('darkMode');
    }
    document.querySelectorAll('.color-changer').forEach(element => {
        element.innerText = 'Light Mode';
    });
    Cookies.set('COLOR_MODE', 'dark')
};

const colorToggle = () => {
    const bodyElement = document.querySelector('body');
    if(bodyElement.classList.contains('darkMode')){
        changeToLight();
    }else{
        changeToDark();
    }
};

document.querySelector('.color-changer').addEventListener('click',evt => {
    colorToggle();
});

if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    changeToDark();
}
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    const newColorScheme = event.matches ? "dark" : "light";
    if(newColorScheme === 'dark'){
        changeToDark();
    }else{
        changeToLight();
    }
});

if(Cookies.get('COLOR_MODE')==='dark'){
    changeToDark();
}