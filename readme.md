# CoachArt

# CoachArt

CoachArt est un site internet qui propose des ateliers artistiques et therapeutiques

Projet en symfony
En cours...


<h4>Images:</h4> 
<p>Installer: composer require vich/uploader-bundle</p>
<p>Ajouter des annotations dans les entités qu'on utilise.</p>
    <p>/**</p>
     <p>* @Vich\UploadableField(mapping="events_images", fileNameProperty="image")</p>
     <p>* @var File</p>
     <p>*/</p>
    <p>private $imageFile;</p>


<h4>Dates: </h4>
<p>composer require knplabs/knp-time-bundle</p>
<p>Consulter documentation pour utiliser:</p>
<p>https://github.com/KnpLabs/KnpTimeBundle</p>
<p>composer require twig/string-extra (Dates->string)</p>

<h4>Entités:</h4> 
<p>Tenir en compte les cascade:["persist"] pour relations..</p>

<a href="https://www.figma.com/file/wLKninePpzJFivIM4A6ICh/Coach-art?node-id=0%3A1">Maquette</a>
<a href="https://lucid.app/lucidchart/25662ae1-33ba-46b4-961b-5e696d1a5737/edit?beaconFlowId=43E5F121AFD6FCA6&invitationId=inv_97166fef-7f61-4e52-b532-85e5bf37403a&page=HWEp-vi-RSFO#">Uml Diagramme</a>
<a href="https://trello.com/b/1sY3VekL/coachart">Plan de travail sur trello</a>
