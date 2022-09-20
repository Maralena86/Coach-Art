/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import Swal from "sweetalert2";

let dels =document.querySelectorAll('.btn-del');
  dels.forEach(del=> {
    del.on('click', function(e){
      e.preventDefault();
      let self = $(this);
      console.log(self.data('title'));
        Swal.fire({
            title: 'Vous êtes sure de réaliser cette action?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              location.href = self.attr('href');
            }
          })
          console.log('hi');
    }, true)
});
        




