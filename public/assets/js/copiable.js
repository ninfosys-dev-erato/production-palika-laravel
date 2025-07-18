document.querySelectorAll('[data-bs-copiable]').forEach(button => {
    button.addEventListener('click', () => {
        const textToCopy = button.getAttribute('data-bs-copiable');
        const textTitle = button.getAttribute('data-bs-title');

        // Create a temporary textarea element
        const tempTextArea = document.createElement('textarea');
        tempTextArea.value = "{{" + textToCopy + "}}";

        // Append the textarea to the document
        document.body.appendChild(tempTextArea);

        // Select the text in the textarea and copy it
        tempTextArea.select();
        tempTextArea.setSelectionRange(0, 99999); // For mobile devices

        try {
            document.execCommand('copy');
            toastr.success(`"${textTitle}" क्लिपबोर्डमा कपि गरियो!`, 'डाटा सफलतापूर्वक कपि गरियो!!!')
            // alert(`"${textToCopy}" copied to clipboard!`);
        } catch (err) {
            console.error('Failed to copy text: ', err);
        }

        // Remove the temporary textarea
        document.body.removeChild(tempTextArea);
    });
});
