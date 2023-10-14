
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<style>

html {
    position: relative;
    min-height: 100%;
}

.footer {
    position: absolute;
    bottom: 0;
    width: 82%;
    height: 60px;
    background: #000000;
    color: #FFFFFF;
}
</style>
<div class="card-header">
    <title>Verification</title>
    </div>
</head>
<body>
    <h4 class="m-4 text-center">Pour garantir la confidentialité et l'intégrité de ce document veuillez entrer vos identifiants afin d'accéder au document <strong>{{$doc->intitule}}</strong> </h4>
@csrf     
    <form  class="m-4 " action="{{ url('api/verifications/create') }}" method="get">
  <div class="form-group">
    <label for="email_verif">Entrez votre adresse E-mail</label>
    <input type="email" class="form-control" id="email_verif" aria-describedby="emailHelp"name="email_verif" placeholder="Votre addresse  email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="nom_verif">Entrez votre nom</label>
    <input type="text" class="form-control" id="nom_verif" name="nom_verif" placeholder="Votre nom">
  </div>
  <div class="form-group">
  <input type="hidden" name="diplome_id" id="diplome_id" value="{{$doc->id}}">
  </div>
  
  <button type="submit" class="btn btn-primary my-2">Soumettre</button>
</form>
</body>
</html>
