require('./bootstrap');

import 'flowbite';

window.saveFieldData = function (inputElement, fieldId) {
  const postData = {
    fieldId,
    value: inputElement.value ? inputElement.value : null
  }
  
  if (typeof fieldId === 'number') {
    fetch('/api/v1/field-data', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(postData)
    })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json(); // parse JSON body
      })
      .then(data => {
        if (data.isOutOfRange) {
          inputElement.classList.add('out-of-range');
        } else {
          inputElement.classList.remove('out-of-range');
        }
      })
      .catch(error => {
        console.error('error', error);
      });
  }
}
