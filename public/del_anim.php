<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- <link rel="stylesheet" href="del_anim.css"> -->
</head>

<body>
  <h1 id="ff">Hello </h1>


  <script src="./del_anim.js"></script>
  <script>
    // Swal.fire(
    //     'Your password has changed',
    //     'Now you can\'t login by your old password.' ,
    //     'success'
    // );
    Swal.fire({
      title: 'Error!',
      text: 'Do you want to continue',
      icon: 'error',
    });

    //    Swal.fire({
    //   title: 'Are you sure?',
    //   text: 'You will not be able to recover this imaginary file!',
    //   icon: 'warning',
    //   showCancelButton: true,
    //   confirmButtonText: 'Yes, delete it!',
    //   cancelButtonText: 'No, keep it'
    // }).then((result) => {
    //   if (result.value) {
    //       setTimeout(()=>{
    //         Swal.fire(
    //         'Deleted!',
    //         'Your imaginary file has been deleted.',
    //         'success'
    //         )
    //       }, 2000);

    //   // For more information about handling dismissals please visit
    //   // https://sweetalert2.github.io/#handling-dismissals
    //   } else if (result.dismiss === Swal.DismissReason.cancel) {
    //     Swal.fire(
    //       'Cancelled',
    //       'Your imaginary file is safe :)',
    //       'error'
    //     )
    //   }
    // })
  </script>
</body>

</html>