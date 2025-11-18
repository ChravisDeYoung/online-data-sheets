require('./bootstrap');

import 'flowbite';

window.getFieldDataHistory = function (fieldId, date, column, modalId) {
  if (!fieldId || !date || !column) {
    return;
  }

  fetch(`/field-data/history?field_id=${fieldId}&page_date=${date}&column=${column}`, {
    method: 'GET',
    headers: {
      'Accept': 'text/html',
    },
  })
    .then(response => {
      if (!response.ok) {
        throw new Error(`invalid status [${response.status}]`);
      }

      return response.text();
    })
    .then(html => {
      document.getElementById(modalId).innerHTML = html;
    })
    .catch(error => {
      console.error(error);
    });
}

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
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(postData)
    })
      .then(response => {
        if (!response.ok) {
          inputElement.value = '';
          throw new Error(`invalid status [${response.status}]`);
        }

        return response.json(); // parse JSON body
      })
      .then(data => {
        if (data.isOutOfRange) {
          inputElement.classList.add('out-of-range');
        } else {
          inputElement.classList.remove('out-of-range');
        }

        // make history icon visible
        const inputHistoryBtn = inputElement.parentElement.querySelector('button[data-modal-toggle="field-data-history-modal"]');
        if (inputHistoryBtn && inputHistoryBtn.style.display === 'none') {
          inputHistoryBtn.style.display = 'block';
        }
      })
      .catch(error => {
        console.error(error);
      });
  }
}
