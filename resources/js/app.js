require('./bootstrap');

import 'flowbite';

window.saveFieldData = function (inputElement, fieldId, column, pageDate) {
  const postData = {
    column,
    fieldId,
    value: inputElement.value ? inputElement.value : null,
    pageDate
  }

  if (inputElement.type === 'checkbox') {
    postData.value = inputElement.checked ? "1" : "0";
  }

  if (typeof fieldId === 'number' && typeof column === 'number') {
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
