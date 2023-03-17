import { result } from "lodash";
import Swal from "sweetalert2";

export function useSwallSuccess(message){

    Swal.fire({
        toast: true,
        icon: "success",
        title: message,
        animation: false,
        position: "top-end",
        showConfirmButton: false,
        timer: 4000,
    })
}


export function useSwallErreur(message){
    Swal.fire({
        toast: true,
        icon: "error",
        title: message,
        animation: false,
        position: "top-end",
        showConfirmButton: false,
        timer: 4000,
    })
}
export function useSwallConfirm(message, callback){
    Swal.fire({
        title: 'Are you sure?',
        text: message,
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
        }
      })
}
