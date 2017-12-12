# PRW2 - Les missions

 Liste de stages (Home)

## 1. Listes de personnes (Davide)

Gérer la liste de personnes impliquées.
Possibilité de filtrer par role:

- Elèves
- Profs (de classe uniquement)
- Responsables technique au sein de l'entreprise/établissement
- Responsables administratif au sein de l'entreprise/établissement

Recherche par texte dans le nom/prénom

Edition des détails. Seuls les élèves ont une adresse; un lien permet de voir l'emplacement sur une carte.

Une personne peut être 'désactivée': elle reste dans la db mais elle disparaît de la liste. Possibilité de lister les personnes désactivées.

Dans les détails d'une personne, on trouve la liste des stages auxquels elle est liée.

## 2. Liste d'entreprises (Antonio)

Gérer la liste de entreprises et établissements partenaires.
Possibilité de filtrer par type.

Edition des détails. Un lien permet de voir l'emplacement sur une carte.

Gestion d'un journal de remarques / commentaires.

Possibilité d'uploader des fichiers relatifs à l'entreprise (par exemple des emails de communication importantes)

Une entreprise peut être 'désactivée': elle reste dans la db mais elle disparaît de la liste. Possibilité de lister les entreprises désactivées.

Dans les détails d'une entreprise, on trouve la liste des stages passés et à venir.

### 3a. Reconduction des stages en cours (Nicolas)

La page permet de voir les stages qui sont en cours. L'utilisateur peut cocher/décocher les stages individuellement ou tous d'un coup.

Il clique ensuite sur 'Reconduire', l'application:

1. Crée des nouveaux stages avec la même description et les même personnes que le stage courant. Ces stages sont placés dans l'état 'Reconduit'
2. Attribue des dates cohérentes (à la suite du stage actuel)
3. Détermine le salaire

### 3b. Gestion documentaire (Nicolas)

Reconstruire la page 'Documents' de l'application

## 4. Planification des visites (Quentin R)

Cette page n'est accessible que pour un prof ayant des élèves en stage, ou un superuser.

### Planification initiale

L'utilisateur introduit des plages horaires de disponibilité. L'application calcule des dates de visite en tenant compte des distances entre les lieux de visite. Elle crée une de visite pour chaque stage dont le prof est responsable. Ces visites sont mises dans l'état 'En préparation'

### Ajustement
Une page permet de déplacer une visite. Tout déplacement réinitialise ses paramètres de suivi (confirmations, email)

## 5. Organisation des visites (Jean-Yves)

Cette page aide à finaliser la confirmation des dates/heures de visite
Elle n'est accessible que pour un prof ayant des élèves en stage, ou un superuser.

Une visite est dans un des états suivants

1. En préparation
2. Confirmée
3. Effectuée

"Mes stagiaires > Visites" montre une liste des visites à mes stagiaires (stagiaire, date, heure). Trois checkboxes permettent de filtrer selon l'état. Au chargement, 'en préparation' et 'confirmée' sont cochées

### Etat 'en préparation'

Icône email à leur droite, lequel peut avoir un 'check' dessus indiquant que le mail a été envoyé.

Clic sur le mail non checké -> ouverture d'un email préparé (pas d'envoi!!!) -> mail devient checké

Clic sur le mail checké -> confirmation -> dé-check

Bouton de confirmation

Clic sur la visite (ligne) -> page de détails de la visite avec possibilité d'édition

### Etat Confirmée

Clic sur la visite (ligne) -> page de détails de la visite avec possibilité d'édition

### Etat Effectuée

Clic sur la visite (ligne) -> page de détails de la visite sans possibilité d'édition

### Détails de la visite

Bouton toggle mode édition

Historique des événements (création, email, changements)

Si mode édition: Bouton 'Evaluer'

Si mode édition: Bouton Suppression

## 6. Grille d'évaluation - Remplissage (Bastien)

Lors de visites, le travail de l'élève est évalué au moyen d'une grille (actuellement une feuille Excel).

Il s'agit ici de permettre la préparation et la validation de cette grille directement dans l'application.

Il doit être possible de faire remplir la grille en mode déconnecté (exportation de la grille vide - importation de la grille remplie)

Durant la visite, on valide les entrées point par point. La note est calculée, un pdf généré et envoyé à l'élève et au responsable de stage.

## 7. Grille d'évaluation - Modélisation (Julien)

Il s'agit ici de permettre à un superuser de modifier la structure de la grille d'évaluation.

## 8. Système de news (Xavier)

Une page permet à chaque utilisateur de consulter les commentaires enregistrés dans le système.

Chaque utilisateur a sa 'date de mise à jour' (dmaj) enregistrée dans l'application. sa signification est "J'ai lu tous les commentaires connus à cette date".

Quand on arrive sur la page de news, l'utilisateur y trouve tous les commentaires émis par un autre utilisateur que lui depuis sa dmaj.

Possibilités de filtrage:

- Par rédacteur
- Par stage
- Afficher également 'mes' commentaires
- Antérieurs à dmaj

Un bouton permet de mettre dmaj à maintenant

## 9. Administration - Synchro intranet (Steven)

Accessible uniquement à un superuser, cette page permet de synchroniser les informations de personnes du CPNV entre l'intranet et la Db de l'application.

Les informations à prendre en considération:

- Liste des élèves concernés par les stages (filière info, voie CFC 4 ans, 3ème ou 4ème année)
- Classes des élèves concernés
- Maîtres de classe des classes concernées

La synchronisation se fait en 3 phases:

1. Evaluation: l'application compare les infos de l'intranet avec le contenu de la db et présente les différences
2. Sélection: pour chaque différence, l'utilisateur peut choisir l'action (appliquer ou ignorer). Possibilité de tout sélectionner/déselectionner.
3. Exécution. Un commentaire automatique est généré


## 10. Matrice de souhaits (Benjamin)

Reproduire (et améliorer) l'existant. Les points importants sont:

- 3 votes par élève par clic sur la cellule. Pas (plus) d'enregistrement des choix dans des commentaires. Seul l'élève peut voter dans sa colonne
- Mise en évidence des stages sans stagiaire et des stagiaires sans stages
- Clic sur une cellule par un superuser ou par un prof = changement d'état de postulaion
- Code couleur à appliquer pour chaque postulation (=cellule):
  - Blanc -> c'est un souhait de l'élève, rien de plus
  - Cyan -> postulation demandée. Les profs ont attribué la place, l'élève doit postuler
  - Bleu -> postulation effectuée. Le MC a reçu copie de la postulation
- Amélioration souhaitée: regroupement des stages similaires (HEIG-VD, IMD, KSA, ...)

## 11. Génération du contrat (Quentin N)

Reproduire le mécanisme existant de génération de contrat:

- Le contenu de TexteContrat est un texte riche (formats, images, etc...)
- Sélection de termes masculins ou féminins selon le choix de genre fait. Les sélections sont signalées par  {{ }} , séparés par un | . Par exemple « l’entreprise versera {{ au | à la }} stagiaire »
- Insertion de données provenant de la db. Les champs d’insertion sont signalés entre {}, par exemple « Sainte-Croix, le {date} », ou «  Nom de l’{{ apprenti | apprentie }} : {PrenomPersonne} {NomPersonne} »
- Possibilité de marquer le contrat comme généré (commentaire automatique)

## 12. Matrice des distances/temps de déplacement (Kevin)

Sur la base de présentation de la matrice des souhaits, afficher au choix soit la distance en km, soit le temps en transports publics

