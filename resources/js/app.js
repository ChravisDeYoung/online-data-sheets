require('./bootstrap');

import 'flowbite';

window.saveFieldData = function (inputValue, fieldId) {
  const postData = {
    fieldId,
    value: inputValue
  }

  if (typeof fieldId === 'number' && inputValue) {
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
        console.log('data', data);
        console.log('fieldData:', data.fieldData);
        console.log('message:', data.message);
      })
      .catch(error => {
        console.error('error', error);
      });
  }
}
