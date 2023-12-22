

document.getElementById('loadMore').addEventListener('click', function () {

    // AJAX request to fetch more users

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse the JSON response
            var response = JSON.parse(xhr.responseText);

            // Append the new users to the list
            var userList = document.getElementById('userList');
            response.users.forEach(function (user) {
                var li = document.createElement('li');
                li.textContent = user.username + ' - ' + user.email;
                userList.appendChild(li);
            });
        }
    };

    // Make the AJAX request to the fetchMoreUsers endpoint

    xhr.open('GET', 'index.php?route=fetchMoreUsers', true);
    xhr.send();
});


function filterjob() {
    let title = document.getElementById('title').value;
    let company = document.getElementById('company').value;
    let location = document.getElementById('location').value;
    let results = document.getElementById("results");

    let data = { title: title };
    if (company.trim() !== '') {
        data = { company: company };
    }
    if (location.trim() !== '') {
        data = { location: location };
    }

    $.ajax({
        method: "POST",
        url: "index.php?route=search",
        data: data,
        success: function (response) {
            results.innerHTML = response;
        },
        error: function () {
            alert("La recherche n'a pas fonctionné.");
        },
    });

    return false;
}



(function () {
    $.ajax({
        method: "GET",
        url: "index.php?route=search",
        data: {},
        success: function (response) {
            console.log("the response is :", response);

        },
        error: function () {
            alert("it doesn't work");
        },
    });
})();

