/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application



import Swal from "sweetalert2";




console.log('JS funcionando')

// window.onscroll = () => {
//     if (window.scrollY > 200) {
//         navbar.classList.add('active');
//     } else {
//         navbar.classList.remove('active');
//     }
// };
const hamburger =document.querySelector(".hamburger-menu");
const navMenu = document.querySelector(".navigation-menu");
hamburger.addEventListener('click', ()=>{
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
})


window.onload = () => {
    
    const FiltersForm = document.querySelector("#search_event");

    document.querySelectorAll("#search_event input").forEach(input =>{
        input.addEventListener("change", ()=>{
      
        })
    });
}

// function changeBg(){
//     let header = document.querySelector(".nav-menu");  
//     if(window.scrollY < 80){
//         header.classList.remove('bgColor')
//     }else{
//         header.classList.add('bgColor')
//     }   
//   }

//   window.addEventListener('scroll', changeBg);
 
let dels =document.querySelectorAll('.btn-del');
  dels.forEach(del=> {
    del.addEventListener('click', function(e){   
      e.preventDefault();
      let link = del;
      let target = del.href; 
        Swal.fire({
            title: 'Vous êtes sure de réaliser cette action?',
            text: "Aprés vous ne pourrais pas revenir en arrière!",
            imageUrl:"https://www.onlygfx.com/wp-content/uploads/2017/12/warning-stamp-2.png",
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer!'
          }).then((result) => {
            if (result.isConfirmed) {
              console.log(result)
              fetch(target, {method: 'get'}).then(response => response.data).then(message => {
                console.log(message)
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              link.closest('tr').fadeOut();
              }).catch(err =>{
                console.log(err)
                Swal.fire({
                  title: 'Oups',
                  text: 'L\'image ne peut pas être effacé, verifier si l\'évenement a été déjà publié',
                }
                )
              })         
            }
          })}, true)});





