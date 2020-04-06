# api-tp-01


## Quel est l'intérêt de créer une API plutôt qu'une application classique ?

L'intéret pricipal est d'avoir le même back pour plusieurs application pour des différents "devices"
En gros avoir le même back pour une application sur mobile, ordinateur / autres
Puis si un jour on veut changer de front on a pas à touche le back.
Puis on peut rendre des information disponible au public via l'api.

## Résumez les étapes du mécanisme de sérialisation implémenté dans Symfony
serialiser passer d'un objet à un format comme json
deserialiser = passer d'un format comme json à un objet

Pour serialiser => on passe par la normalisation, transformer un objet en tableau. => Puis on encode = transformer le tableau dans un format comme json
Pour déserialiser => on passe par le décodage transformer un format comme json en tableau. => Puis on passe par la dénormalisation transformer un tableau en objet

## Qu'est-ce qu'un groupe de sérialisation ? A quoi sert-il ?
C'est un groupe qu'on va pouvoir attribuer a des champs d'une entité et cela nous permet de filtrer les champs que l'on souhaite retourner 

## Quelle est la différence entre la méthode PUT et la méthode PATCH ?
Put permet de modifier l'entité entièrement
Patch permet de modifier seulement une partie (cependant on peut tout modifier ou juste un champ, ou plusieurs)


## Quels sont les différents types de relation entre entités pouvant être mis en place avec Doctrine ?
OneToOne
OneToMany
ManyToOne
ManyToMany

## Qu'est-ce qu'un Trait en PHP et à quoi peut-il servir ?

Un trait est un bout de code php réutilisable dans d'autre fichiers php