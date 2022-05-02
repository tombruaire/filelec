<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<div class="alert alert-success" role="alert">
				<h3 class="text-center">
					Bienvenue sur votre messagerie !
				</h3>
			</div>
		</div>
	</div>
</div>

<div class="container mt-4 mb-4">
    <div class="row d-flex justify-content-center">
        <div class="col-auto">
            <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#sendMessage">
                Envoyer un message
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="sendMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Envoi d'un message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
                <input type="hidden" name="idclient" value="<?= $_SESSION['idclient']; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Destinataire</label>
                        <select name="id_dest" class="form-select">
                            <?php
                            $unControleur->setTable("client");
                            $lesClients = $unControleur->selectAll();
                            foreach ($lesClients as $unClient) { ?>
                                <option value="<?= $unClient['idclient']; ?>"><?= $unClient['nom']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Message</label>
                        <textarea name="contenu" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="Envoyer" class="btn btn-success w-100">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row d-flex justify-content-center">
        <div class="card bg-dark">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-striped text-center">
                        <thead>
                        <tr>
                            <th scope="col">Expéditeur</th>
                            <th scope="col">Message</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($lesMessages) { ?>
                            <?php foreach ($lesMessages as $unMessage) { ?>
                                <tr>
                                    <td><?= $unMessage['expediteur'] ?></td>
                                    <td><?= $unMessage['contenu'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#sendMessage">Répondre</button>
                                        <a href="messages&action=sup&idmessage=<?= $unMessage['idmessage']; ?>" class="btn btn-danger" onclick="return(confirm('Voulez-vous vraiment supprimer ce message ?'));">
                                            Supprimer
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4">Vous n'avez aucun message</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
