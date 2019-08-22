
<html lang="fr">
<style>
    .txt-center{text-align: center}
    .txt-right{text-align: right}
    .txt-left{text-align: left}
    body{width:870px; margin: auto}
    .flex{display: flex;}
    .border{border: 1px solid #D3D3D3; padding: 10px;}
    .space{justify-content: space-between}
    table {
        width: 100%;
        color: #717375;
        line-height: 5mm;
        border-collapse: collapse;
        margin-top: 25px;
    }
    .25p { width: 25%; }
    .75p { width: 75%; }
    .50p { width: 50%; }
    h1{padding-top: 10px;}
</style>
<?php $nom="antoine"; $prenom="michel"; $tel="0320456897"; $email="jeandujardin@élysé.fr"; ?>
<body>
<h1 class="txt-center">Devis</h1>
<p class="txt-center">Ce devis est à titre indicatif et ne constitue en aucun cas un acte de vente.<br/> Veuillez vous rapprochez de nos équipes afin d'obtenir un devis final</p>
<div class="flex space">
    <div class="border">
        <strong>Détail de l'entreprise :</strong><br /><br />
        Société North Web<br />
        06.20.76.34.48<br />
        contact.northweb@gmail.com
    </div>
    <div class="border">
        <strong>Coordonnée du client :</strong><br /><br />
        <?php echo ucfirst($nom).' '.ucfirst($prenom) ?><br />
        <?php echo $tel ?><br />
        <?php echo $email ?>
    </div>
</div>
<table>
    <thead>
    <tr>
        <th class="75p border">Désignation</th>
        <th class="25p border">Quantité</th>
        <th class="25p border">Prix Unitaire</th>
        <th class="25p border">Prix Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Maquette</td>
        <td><? echo $maquette; ?></td>
        <td><? echo prixmaquette; ?></td>
        <td><? echo $totmaquette; ?></td>
    </tr>
    </tbody>
</table>










</body>
</html>
