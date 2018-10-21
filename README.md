# Tweetschool
 Tweetschool (aka Evolv) est un clône (plutôt) simplifié de de Twitter. Il permet de publier à un tweet, répondre à un tweet, retweeter un tweet, follow/unfollow des personnes, rechercher des membres, modifier son profil, et afficher un fil d'actualité (la liste des tweets des personnes qui l'utilisateur courant a follow). Les administrateurs et modérateurs ont aussi des privilèges (bannir des utilisateurs, supprimer des tweets).
 
 Au sommaire :
  1. Installation
  1. Scénario
  1. Ce qu'il reste à faire
  1. Ouverture sur une contrainte de Twitter (le vrai Twitter)  

## Installation

1. Installer les packages de Yarn avec `yarn install`.
1. Installer les packages de Composer avec `composer install`.
1. Créer une base de données et adapter le fichier `.env` pour se connecter à la base de donnée.
1. Lancer les migrations : `bin/console doctrine:migrations:migrate` pour alimenter la base de données.
1. Charger les fixtures : `bin/console doctrine:fixtures:load` (optionnel).
1. Enjoy :)

## Scénario
Il existe les utilisateurs suivants : (définis dans les fixtures)
1. Frank Sinatra
1. Tony Curtis
1. Marilyn Monroe (elle a le rôle __admin__)
1. John Wayne (il a le rôle __mod__ (modérateur) parce que c'est le shérif bien sûr)
1. Rita Hayworth
1. Clint Eastwood

Chaque utilisateur a une école. En l'occurence, il s'agit d'Ynov et pour le moment seuls les élèves d'Ynov peuvent s'inscrire avec leur adresse mail @ynov.com (les plus grandes légendes d'Hollywood ont toutes étudiées à Ingésup d'ailleurs).

## Ce qu'il reste à faire
1. Sécuriser un minimum le site. Par exemple, une personne non connectée ne devrait pas pouvoir accéder au formulaire pour publier un nouveau message.
1. Créer les tests fonctionnels.
1. Implémenter les fonctionnalités qui rendraient ce site unique. À la base, ce site devait permettre aux personnes d'une même école de faire partie d'un groupe exclusivement ouvert aux membres de cette école. Chacun de ces groupes seraient donc en "conccurence" (par exemple les membres d'Ynov et d'Epitech).

Ces fonctionnalités n'ont pas été implémentées par manque de temps. _But it's never too late._

## Contrainte
Quand un membre est supprimé par le modérateur, ses messages sont supprimés (sinon il y a des erreurs fatales). Le problème, c'est que chaque message peut avoir en théorie un infinité de messages enfants. Avant de supprimer un message, il est donc obligatoire de supprimer ses messages enfants. Puisqu'il est n'est pas possible de déterminer à l'avance le nombre de messages enfants (enfin si mais bon), j'ai donc créé une fonction récursive qui, avant de supprimer un message, vérifie si ce message a des messages enfants. Si c'est le cas, alors, la fonction s'appelle elle-même pour effectuer le même travail sur le message enfant jusqu'à ce qu'il n'y ait plus de messages enfants.

En réalité, Twitter ne supprime jamais un tweet. À la place d'être supprimé, le message n'est simplement pas affiché. En effet, légalement, Twitter n'a pas le droit de supprimer de messages (en plus c'est une mauvaise pratique). Mais le fait d'avoir été confronté avec ce problème de récursivité m'a montré qu'il y a une autre raison pour laquelle Twitter ne supprime pas les messages.

Si Twitter décidait de supprimer un tweet, il faudrait aussi supprimer toutes les réponses qui sont liées au parent par une clef étrangère. Dans la plupart des cas, une fonction récursive (comme ça a été fait ici) fonctionnerait. Mais pour les cas où un tweet a trop de réponses, cela deviendrait vite impossible techniquement.

Par exemple, si une personne très célèbre publie un tweet raciste, et que ce tweet obtient plusieurs centaines de milliers de réponses avant que les modérateurs ne voient le tweet (et que, en plus chaque réponse reçoit aussi une réponse), il sera impossible pour le serveur de supprimer tous les messages. Le processeur ne peut faire appel qu'à un nombre limité de fonctions récursives et beaucoup de ressources seraient consommées ce qui pourrait ralentir considérablement le serveur.