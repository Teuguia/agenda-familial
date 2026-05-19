# 📘 Agenda Familial - Guide de Démarrage

## ✅ Implémentation Complète

Toute l'application a été mise en place selon le cahier de charges. Voici ce qui a été créé:

### 1. **Base de Données** 📊
- ✅ 7 migrations créées (families, members, events, tasks, shopping_lists, etc.)
- ✅ Migrations exécutées avec succès
- ✅ Données de test insertées (1 parent, 1 enfant, 1 famille)

### 2. **Modèles Eloquent** 🧩
- ✅ Family.php - Gestion des familles
- ✅ Member.php - Membres avec rôles
- ✅ Event.php - Événements du calendrier
- ✅ Task.php - Tâches assignées
- ✅ ShoppingList.php & ShoppingItem.php - Listes de courses
- ✅ User.php - Mis à jour avec relation member

### 3. **Contrôleurs** 🎮
- ✅ FamilyController - Gestion des familles
- ✅ EventController - CRUD événements
- ✅ TaskController - CRUD tâches + changement de statut
- ✅ ShoppingListController - CRUD listes + items
- ✅ MemberController - Gestion des membres
- ✅ Auth controllers - LoginController & RegisterController

### 4. **Middleware** 🛡️
- ✅ CheckRole - Vérifie le rôle de l'utilisateur (parent/enfant)
- ✅ CheckFamilyMember - Vérifie l'appartenance à une famille
- ✅ Middleware enregistrés dans Kernel.php

### 5. **Notifications** 🔔
- ✅ TaskAssigned - Notification lors de l'assignation d'une tâche
- ✅ EventReminder - Rappel d'événement (optionnel)

### 6. **Routes** 🛣️
- ✅ Routes web.php - Avec auth middleware
- ✅ Routes api.php - Pour API mobile (Sanctum)

### 7. **Vues Blade** 👁️
- ✅ layouts/app.blade.php - Layout principal
- ✅ auth/login.blade.php & register.blade.php
- ✅ family/index.blade.php - Gestion de la famille
- ✅ events/index.blade.php, create.blade.php, edit.blade.php
- ✅ tasks/index.blade.php, create.blade.php, edit.blade.php
- ✅ shopping-lists/index.blade.php, create.blade.php, edit.blade.php
- ✅ members/index.blade.php - Gestion des membres
- ✅ dashboard.blade.php - Page d'accueil

---

## 🚀 Démarrer l'Application

### Serveur de développement
```bash
cd /home/most/Bureau/laravel/agenda-familial
php artisan serve
```
L'application sera disponible à: **http://localhost:8000**

### Identifiants de test
```
Parent (Admin):
- Email: parent@example.com
- Password: password123

Enfant (Utilisateur):
- Email: child@example.com
- Password: password123
```

---

## 📋 Fonctionnalités Implémentées

### ✅ Authentification
- Registration & Login
- Déconnexion
- Validation des emails

### ✅ Gestion des familles
- Créer une famille
- Rejoindre une famille (code d'invitation)
- Supprimer une famille (parent only)

### ✅ Gestion des membres
- Lister les membres
- Changer le rôle (parent ↔ enfant)
- Supprimer un membre (parent only)

### ✅ Calendrier
- Créer/Modifier/Supprimer événements
- Assigner à un membre
- Visualiser les événements par date

### ✅ Tâches
- Créer/Modifier/Supprimer tâches
- Assigner à un membre
- Changer le statut (à faire → en cours → terminé)
- Notifications d'assignation

### ✅ Listes de courses
- Créer/Modifier/Supprimer listes
- Ajouter des articles
- Marquer comme achetés
- Quantités

### ✅ Sécurité
- Contrôle des rôles (parent/enfant)
- Authentification requise
- Validation des données
- Protection CSRF

---

## 🔧 Commandes Utiles

```bash
# Démarrer le serveur
php artisan serve

# Rafraîchir la DB avec données de test
php artisan migrate:refresh --seed

# Créer un nouvel utilisateur
php artisan tinker
User::create(['name' => 'Nom', 'email' => 'email@test.com', 'password' => bcrypt('password')])

# Voir tous les modèles
php artisan tinker
# Ensuite : Family::all(), Member::all(), etc.
```

---

## 📱 API REST (Bonus)

Des routes API sont disponibles pour une application mobile:
- `GET /api/events` - Lister les événements
- `POST /api/events` - Créer un événement
- `PATCH /api/tasks/{task}/status` - Changer le statut d'une tâche

⚠️ Nécessite l'authentification via Laravel Sanctum.

---

## 🎯 Prochaines Étapes (Optionnel)

1. **Améliorer l'UI**
   - Ajouter des animations
   - Icônes Font Awesome
   - Mode sombre

2. **Notifications en temps réel**
   - WebSockets avec Pusher
   - Queue jobs

3. **Synchronisation mobile**
   - Développer une app mobile (React Native/Flutter)
   - Consommer l'API REST

4. **Améliorations**
   - Filtrage avancé
   - Export PDF des listes
   - Rappels email/SMS

---

## 📞 Support

Pour toute question sur le code, consultez les commentaires dans:
- `app/Models/` - Logique des modèles
- `app/Http/Controllers/` - Logique métier
- `resources/views/` - Affichage

Bonne chance! 🚀
