<!-- BARRE DE RECHERCHE -->
<div class="container mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-auto">
            <form method="post" action="">
                <div class="card animate__animated animate__backInDown">
                    <div class="card-body">
                        <span class="input">
                            <input type="search" name="mot" placeholder="Rechercher..." style="margin-right: 5px!important;">
                            <span></span>
                        </span>
                        <button type="submit" name="Rechercher" class="submitButtonSearch">
                            &nbsp;&nbsp;Rechercher&nbsp;&nbsp;
                        </button>
                    </div>
                </div>              
            </form>
        </div>
    </div>
</div>
<!-- / BARRE DE RECHERCHE -->

<!-- FILTRAGE DES TYPES DE PRODUITS -->
<div class="container mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-auto">
            <form method="post" action="">
                <div class="card animate__animated animate__backInDown">
                    <div class="card-body">
                        <select name="idtype" class="form-control form-select form-control-lg">
                            <?php foreach ($lesTypes as $unType) { ?>
                                <option value="<?= $unType['idtype']; ?>">
                                    <?= $unType['libelle']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex justify-content-center">
                            <div class="col-auto">
                                <button type="submit" name="Valider" class="btn btn-success w-100">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </div>              
            </form>
        </div>
    </div>
</div>
<!-- / FILTRAGE DES TYPES DE PRODUITS -->

<!-- PAGINATION -->
<div class="d-flex justify-content-center mt-4 mb-4">
    <ul class="ul-pagination reveal-1">
        <?php if ($pageCourante <= 1) { ?>
        <li style="margin-top: 1vh;">
            <a href="javascript:void(0)" style="cursor: default;">Précédent</a>
        </li>
        <?php } else { ?>
        <li style="margin-top: 1vh;">
            <a href="produits?p=<?= $pagePrecedente; ?>" class="text-primary">Précédent</a>
        </li>
        <?php } ?>
        <?php for ($i=1; $i<=$pagesTotales; $i++) { ?>
        <?php if ($i == $pageCourante) { ?>
        <li class="pageNumber active" style="margin-top: 1vh; margin-bottom: 1vh;">
            <a href="produits?p=<?= $i; ?>"><?= $i; ?></a>
        </li>
        <?php } else { ?>
        <li class="pageNumber" style="margin-top: 1vh; margin-bottom: 1vh;">
            <a href="produits?p=<?= $i; ?>"><?= $i; ?></a>
        </li>
        <?php } ?>
        <?php } ?>
        <?php if ($pageCourante >= $pagesTotales) { ?>
        <li style="margin-top: 1vh;">
            <a href="javascript:void(0)" style="margin-right: 1.7rem!important; cursor: default;">Suivant</a>
        </li>
        <?php } else { ?>
        <li style="margin-top: 1vh;">
            <a href="produits?p=<?= $pageSuivante; ?>" class="text-primary" style="margin-right: 1.7rem!important;">Suivant</a>
        </li>
        <?php } ?>
    </ul>
</div>
<!-- / PAGINATION -->

<?php if (isset($erreur)) { ?>
<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<div class="alert alert-secondary alert-dismissible fade show" role="alert">
  				<strong><?= $erreur; ?></strong>
  				<form method="post" action="">
  					<button type="submit" name="Refesh" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php if (isset($message)) { ?>
<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
  				<strong><?= $message; ?></strong>
  				<form method="post" action="">
  					<button type="submit" name="Refesh" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<div class="container mt-4">
	<div class="row">
		<?php foreach ($lesProduits as $unProduit) { ?>
		<div class="col-lg-3 mb-5">
			<div class="card animate__animated animate__zoomIn">
				<a href="produit?view=<?= $unProduit['idproduit']; ?>">
					<img src="assets/images/produits/<?= $unProduit['imageproduit']; ?>" class="card-img-top mt-2" alt="">
				</a>
				<div class="card-body text-center">
					<a href="produit?view=<?= $unProduit['idproduit']; ?>" class="text-dark" style="text-decoration: none;">
						<h5 class="card-title"><?= $unProduit['nomproduit']; ?></h5>
					</a>
					<p class="card-text">
						<?= number_format($unProduit['prixproduit'], 2, ',', ' '); ?> €
					</p>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="d-flex justify-content-center mt-4 mb-5">
            <div class="d-flex justify-content-center mt-4 mb-4">
                <ul class="ul-pagination reveal-2">
                    <?php if ($pageCourante <= 1) { ?>
                    <li style="margin-top: 1vh;">
                        <a href="javascript:void(0)" style="cursor: default;">Précédent</a>
                    </li>
                    <?php } else { ?>
                    <li style="margin-top: 1vh;">
                        <a href="produits?p=<?= $pagePrecedente; ?>" class="text-primary">Précédent</a>
                    </li>
                    <?php } ?>
                    <?php for ($i=1; $i<=$pagesTotales; $i++) { ?>
                    <?php if ($i == $pageCourante) { ?>
                    <li class="pageNumber active" style="margin-top: 1vh;">
                        <a href="produits?p=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                    <?php } else { ?>
                    <li class="pageNumber" style="margin-top: 1vh;">
                        <a href="produits?p=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                    <?php } ?>
                    <?php } ?>
                    <?php if ($pageCourante >= $pagesTotales) { ?>
                    <li style="margin-top: 1vh;">
                        <a href="javascript:void(0)" style="margin-right: 1.7rem!important; cursor: default;">Suivant</a>
                    </li>
                    <?php } else { ?>
                    <li style="margin-top: 1vh;">
                        <a href="produits?p=<?= $pageSuivante; ?>" class="text-primary" style="margin-right: 1.7rem!important;">Suivant</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            </nav>
        </div>
	</div>
</div>

<script type="text/javascript">
    const selected = document.querySelector(".selected");
    const optionsContainer = document.querySelector(".options-container");
    const searchBox = document.querySelector(".search-box input");
    const optionsList = document.querySelectorAll(".option");

    selected.addEventListener("click", () => {
        optionsContainer.classList.toggle("active");
        searchBox.value = "";
        filterList("");
        if (optionsContainer.classList.contains("active")) {
            searchBox.focus();
        }
    });

    optionsList.forEach(o => {
        o.addEventListener("click", () => {
            selected.innerHTML = o.querySelector("label").innerHTML;
            optionsContainer.classList.remove("active");
        });
    });

    searchBox.addEventListener("keyup", function(e) {
        filterList(e.target.value);
    });

    const filterList = searchTerm => {
        searchTerm = searchTerm.toLowerCase();
        optionsList.forEach(option => {
            let label = option.firstElementChild.nextElementSibling.innerText.toLowerCase();
            if (label.indexOf(searchTerm) != -1) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        });
    };
</script>