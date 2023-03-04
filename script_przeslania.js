var randomAnswer = 15;

$ (document).ready(function() {
return $.ajax({
    url: 'tworzenie_meczu.php',
    type: 'POST',
    data: randomAnswer,
    });
});