
function deleteContact(id) {

  const url = `/api/contact`;

  fetch(url + `/${id}`, {
    method: 'DELETE',
    mode: 'cors',
    headers: { "Content-type": "application/json;" },
  }).then(data => {
    console.log(data);
    location.reload();
  })
    .catch(error => console.error(error));
  
}

function formatData(originalDate){
  const date = new Date(originalDate);
  var formattedDate = date.toISOString().slice(0, 10);
  return formattedDate;
}

$(document).ready(function () {
  var modal = document.getElementById("myModal");
  var form = document.getElementById("profile-form");

  var nameInput = document.getElementById("name");
  var emailInput = document.getElementById("email");
  var cpfInput = document.getElementById("cpf");
  var birthInput = document.getElementById("birth");

  var userId = null;

  // nameInput.value = "John Doe";
  // emailInput.value = "johndoe@example.com";
  // birthdateInput.value = "1990-01-01";
  // populatePhones(["555-1234", "555-5678", "555-9012"]);

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    const url = `/api/contact`;
    console.log(formatData(birthInput.value));

    if (userId == null) {

      var phone = [];
      $('.phone-value').each(function () {
        phone.push({ phone_number: $(this).val() });
      });

      var data = JSON.stringify({
        name: nameInput.value,
        email: emailInput.value,
        birth: formatData(birthInput.value),
        cpf: cpfInput.value,
        phone: phone
      });

      fetch(url, {
        method: 'POST',
        mode: 'cors',
        headers: { "Content-type": "application/json;" },
        body: data
      }).then(data => {
        console.log(data);
        location.reload();
      })
        .catch(error => console.error(error));
    } else {
      var phone = [];
      $('.phone-value').each(function () {
        phone.push({ phone_number: $(this).val() });
      });

      var data = JSON.stringify({
        name: nameInput.value,
        email: emailInput.value,
        birth: formatData(birthInput.value),
        cpf: cpfInput.value,
        phone: phone
      });

      fetch(url + `/${userId}`, {
        method: 'PATCH',
        mode: 'cors',
        headers: { "Content-type": "application/json;" },
        body: data
      }).then(data => {
        console.log(data);
        location.reload();
      })
        .catch(error => console.error(error));

    }

  });

  $("#add-phone-btn").click(function () {
    var phonesList = $("#phones");
    phonesList.append('<li class="list-group-item"><div class="d-flex justify-content-between"><div class="flex-grow-1"><input type="tel" class="form-control phone-value" name="phones[]" placeholder="Enter phone number"></div><div class="align-self-center ml-3"><button type="button" class="btn btn-outline-danger btn-sm delete-phone-btn"><i class="fas fa-trash-alt"></i></button></div></div></li>');
  });



  $("#phones").on("click", ".delete-phone-btn", function (e) {
    $(this).closest("li").remove();
  });

  const searchButton = document.getElementById('search');
  const resultsDiv = document.getElementById('results');


  function populatePhones(phone) {
    var phonesList = $("#phones");
    phonesList.empty();
    phone.forEach(function (phoneInfo) {
      phonesList.append('<li class="list-group-item"><div class="d-flex justify-content-between"><input type="tel" class="form-control phone-value" name="phones[]" value="' + phoneInfo.phone_number + '" disabled placeholder="Enter phone number"><div class="align-self-center ml-3"><button type="button" class="btn btn-outline-danger btn-sm delete-phone-btn"><i class="fas fa-trash-alt"></i></button></div></div></li>');
    });
  }


  $("#myModal").on("shown.bs.modal", function (e) {

    var id = $(e.relatedTarget).data('id');
    userId = id;

    const url = `/api/contact/${id}`;

    fetch(url)
      .then(response => response.json())
      .then(data => {
        data.forEach(person => {
          nameInput.value = person.name;
          emailInput.value = person.email;
          cpfInput.value = person.cpf;
          birthInput.value = formatData(person.birth);
          populatePhones(person.phone);
        });

      })
      .catch(error => console.error(error));

  });

  $("#myModal").on("hidden.bs.modal", function (e){
    nameInput.value = '';
    emailInput.value = '';
    cpfInput.value = '';
    birthInput.value = '';
    populatePhones([]);
  });

  function getContacts() {
    const name = document.getElementById('name').value;
    //const birthdate = document.getElementById('birth').value;

    const url = `/api/contact?name=${name}`;

    fetch(url)
      .then(response => response.json())
      .then(data => {
        let html = '';

        data.forEach(person => {
          html += ` 
            <div class="card w-100 mt-3">
            <div class="card-body">
              <h5 class="card-title">${person.name}</h5>
              <p class="card-text">${person.email}</p>
              <a href="#" class="btn btn-primary" data-id="${person.id}" id="edit-contact-btn" data-toggle="modal" data-target="#myModal">Edit</a>
              <a href="#" class="btn bg-danger text-white" data-id="${person.id}" onClick="deleteContact(${person.id})">Delete</a>
            </div>
          </div>`;
        });


        resultsDiv.innerHTML = html;
      })
      .catch(error => console.error(error));
  }


  getContacts();

  searchButton.addEventListener('click', () => {
    getContacts();
  });

});