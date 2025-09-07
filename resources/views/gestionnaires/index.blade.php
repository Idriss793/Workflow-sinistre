<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Accueil</title>
    <style>
        .listForm {
            width: 100%;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        .nav-list{
            display: flex;
            list-style: none;
            position: relative;
            padding: 0;
            margin: 0;
        }
        .nav-list li{
            flex: 1;
            text-align: center;
        }
        .nav-list a{
            display: block;
            padding: 15px 0;
            text-decoration: none;
            color: #34495e;
            font-weight: 500;
            position: relative;
            transition: color 0.3s;
        }

       
        .nav-list a:hover {
            color: #3498db;
        }

        /* Barre de soulignement */
        .underline{
            position: absolute;
            bottom: 0;
            height: 4px;
            background-color: #3498db;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        /* style de l'élément actif */
        .nav-list a.active {
            color: #3498db;
        }

        /* Contenu pour visualiser le résultat */
        .content{
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .content-section{
            display: none;
        }

        .content-section.active{
            display:block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {opacity:0;}
            to {opacity: 1;}
        }

    </style>
   
  </head>
  <body>
    <div class="container-fluid">
        <div class="row" style="height: 100vh;">
            <div class="col-2 col-sm-3 col-xl-2 " style="background-color: #8995ccff;">
                <div class="sticky-top">
                    <nav class="navbar border-bottom border-white mb-3" data-bs-theme="dark">
                        <div class="container-fluid" >
                            <a class="navbar-brand" href="#">
                                <i class="fas fa-home"></i><span class="d-none d-sm-inline ms-2">SUNU</span>
                            </a>
                        </div>
                    </nav>
                    <nav class="nav flex-column">
                        <a class="nav-link text-white" style="white-space: nowrap;" href="{{url('declarerSinistre')}}">
                            <i class="fas fa-plus"></i><span class="d-none d-sm-inline ms-2">Déclarer un sinistre v2</span>
                        </a>
                        <a class="nav-link text-white" style="white-space: nowrap;" href="{{url('home')}}">
                            <i class="fas fa-plus"></i><span class="d-none d-sm-inline ms-2">Déclarer un sinistre</span>
                        </a>
                        <a href="{{url('liste_sinistre')}}" class="nav-link text-white" style="white-space: nowrap;" >
                            <i class="fas fa-list"></i><span class="d-none d-sm-inline ms-2">Consulter un sinistre</span>
                        </a>
                        
                    </nav>
                </div>
            </div>

            <div class="col-10 col-sm-9 col-xl-10 p-0 m-0">
                <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3 sticky-top">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Dashboard</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Sinistres en cours de traitement</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" href="#">Sinistres clôturés</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Rapports</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Paramètres</a>
                                </li>
                            </ul>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                </nav>
                <h2 class="text-center mb-5">Déclaration d'un sinistre</h2>

                <div class="listForm">
                    <ul class="nav-list" id="navList">
                        <li>
                            <a href="#" class="active" data-index="0">Infos Sinistre</a>
                        </li>
                        <li>
                            <a href="#" data-index="1">Assuré principal</a>
                        </li>
                        <li>
                            <a href="#" data-index="2">Assuré tiers</a>
                        </li>
                        <li>
                            <a href="#" data-index="3">Téléverser un document</a>
                        </li>
                    </ul>
                    <div class="underline" id="underline"></div>
                </div>
                
                <div class="content">
                    <!-- partie information sinistre -->
                    <div class="container mt-5">
                        <div class="row justify-content-left">
                            <div class="col-md-6 col-lg-5">
                                <div class="content-section active" id="content-0">
                                    <h2>Information sur le sinistre</h2>
                                    <form action="">
                                        @csrf
                                         <div class="mb-3">
                                            <label for="date_sinistre" class="form-label">Date du sinistre</label>
                                            <input type="date" class="form-control" id="date_sinistre" name="date_sinistre" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="Lieu" class="form-label">Lieu du sinistre</label>
                                            <input type="text" class="form-control" id="lieu" name="lieu" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" ></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="autoSizingSelect" class="form-label">Type de sinistre</label>
                                            <select class="form-select" id="autoSizingSelect">
                                                <option selected>Choisir...</option>
                                                <option value="1">Voiture à voiture</option>
                                                <option value="2">Voiture à bien</option>
                                                <option value="3">Voiture à personne</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Ajouter une image ou une vidéo</label>
                                            <input class="form-control" type="file" id="formFile">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- partie assuré principale -->
                    <div class="container mt-0">
                        <div class="row justify-content-left">
                            <div class="col-md-6 col-lg-5">
                                <div class="content-section" id="content-1">
                                    <h2>Assuré principal</h2>
                                    <form action="">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nom" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom">
                                        </div>
                                        <div class="mb-3">
                                            <label for="prenom" class="form-label">Prenom</label>
                                            <input type="text" class="form-control" id="prenom" name="prenom">
                                        </div>
                                        <div class="mb-3">
                                            <label for="num_tel" class="form-label">Numéro de téléphone</label>
                                            <input type="tel" class="form-control" id="num_tel" name="num_tel">
                                        </div>
                                        <div class="mb-3">
                                            <label for="num_pol" class="form-label">Numéro de police</label>
                                            <input type="text" class="form-control" id="num_pol" name="num_pol">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="nom_assurance_tiers" class="form-label">Nom de la compagnie assurance tiers</label>
                                            <input type="tel" class="form-control" id="nom_assurance_tiers" value="" name="nom_assurance_tiers" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="contact_assurance_tiers" class="form-label">Contact de l'assurance tiers</label>
                                            <input type="tel" class="form-control" id="contact_assurance_tiers" value="" name="contact_assurance_tiers" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="num_matri" class="form-label">Numéro de matricule de la voiture</label>
                                            <input type="text" class="form-control" id="num_matri" name="num_matri">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- partie assuré tiers -->
                    <div class="container mt-0">
                        <div class="row justify-content">
                            <div class="col-md-12">
                                <div class="content-section" id="content-2">
                                    <h2 class="text-center mb-4">Assuré & compagnie tiers</h2>
                                    <form  action="">
                                        @csrf
                                       
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p class="fw-bold text-center">Assuré tiers</p>
                                                <div class="mb-3">
                                                <label for="nom_tiers" class="form-label">Nom</label>
                                                <input type="text" class="form-control" id="nom_tiers" name="nom_tiers">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="prenom_tiers" class="form-label">Prenom</label>
                                                    <input type="text" class="form-control" id="prenom_tiers" name="prenom_tiers">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="num_tel_tiers" class="form-label">Numéro de téléphone</label>
                                                    <input type="tel" class="form-control" id="num_tel_tiers" name="num_tel_tiers">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="num_pol_tiers" class="form-label">Numéro de police</label>
                                                    <input type="text" class="form-control" id="num_pol_tiers" name="num_pol_tiers">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="num_matri_tiers" class="form-label">Numéro de matricule de la voiture</label>
                                                    <input type="text" class="form-control" id="num_matri_tiers" name="num_matri_tiers">
                                                </div>
                                            </div>

                                            <div class="col-md-5 ms-auto">
                                                <p class="fw-bold text-center">Compagnie assurance tiers</p>
                                                <div class="mb-3">
                                                <label for="nom_assurance" class="form-label">Nom de la compagnie assurance</label>
                                                <input type="text" class="form-control" id="nom_assurance" name="nom_assurance">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="lieu_assurance_tiers" class="form-label">Localisation</label>
                                                    <input type="text" class="form-control" id="lieu_assurance_tiers" name="lieu_assurance_tiers">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="contact" class="form-label">Contact</label>
                                                    <input type="tel" class="form-control" id="contact" name="contact">
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="mb-2 text-center">
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Partie document -->
                    <div class="container mt-0">
                        <div class="row justify-content-center">
                            <div >
                                <div class="content-section" id="content-3">
                                    <h2>Documents</h2>
                                    <div class="card-body">
                                        <table class="table table-stiped table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Type</th>
                                                    <th>Taille</th>
                                                    <th>date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                                    <tr>
                                                        <td>Contrat</td>
                                                        <td>887 KB</td>
                                                        <td>03 sept.2025 14:37</td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn btn-success">modifier</a>
                                                            <a href="#" class="btn btn-info">voir</a>
                                                            <form action="#" class="d-inline" method="POST">
                                                                @csrf
                                                               
                                                                <button type="submit" class="btn btn-danger">supprimer</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-list a');
            const underline = document.getElementById('underline');
            const contentSections = document.querySelectorAll('.content-section');
                    
        
            // Changement d'onglet
            function changeTab(index) {
                // Mettre à jour les liens
                navLinks.forEach(link => link.classList.remove('active'));
                navLinks[index].classList.add('active');
                
                // Mettre à jour le contenu
                contentSections.forEach(section => section.classList.remove('active'));
                contentSections[index].classList.add('active');
                
                
            }
            
            // Ajouter les événements de clic
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const index = parseInt(this.getAttribute('data-index'));
                    changeTab(index);
                });
            });
            
        
            
            // Ajuster la barre de soulignement lors du redimensionnement de la fenêtre
            window.addEventListener('resize');
        });
    </script>
  </body>
</html>