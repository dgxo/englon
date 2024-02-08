let fileInput = document.getElementById('fileinput');
let form = document.getElementById('uploadform');

fileInput.onchange = () => {
   const selectedFile = fileInput.files[0];
   console.log(selectedFile);
   form.submit();
};
