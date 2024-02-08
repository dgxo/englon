function altDownload(filename, element) {
   const downloadLink = document.createElement('a');
   const icon = element.querySelector('i');

   let newFilename = filename + '.renamethis';

   icon.classList = 'fa-solid fa-spinner fa-spin';

   // Use the Fetch API to fetch the file content
   fetch('files/' + filename)
      .then((response) => response.blob())
      .then((blob) => {
         // Create a new blob with the renamed file
         const renamedBlob = new Blob([blob], { type: blob.type });
         renamedBlob.name = newFilename;

         // Set the download attribute of the anchor tag to the new filename
         downloadLink.download = newFilename;

         // Create a URL for the renamed file blob and set it as the href attribute of the anchor tag
         downloadLink.href = URL.createObjectURL(renamedBlob);

         // Trigger a click on the anchor tag to initiate the download
         downloadLink.click();
         icon.classList = 'fa-solid fa-download';
      });
}
