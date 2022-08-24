# CoachArt

CoachArt est un site internet qui propose des ateliers artistiques et therapeutiques

Projet en symfony
En cours...


Images: 
Installer: composer require vich/uploader-bundle
Ajouter des annotations dans les entités qu'on utilise.
    /**
     * @Vich\UploadableField(mapping="events_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;


Dates: 
composer require knplabs/knp-time-bundle
Consulter documentation pour utiliser:
https://github.com/KnpLabs/KnpTimeBundle
composer require twig/string-extra (Dates->string)

Entités: 
Tenir en compte les cascade:["persist"] pour relations..
