# 🎣 wobbleIT Fishing Manager 

Fishing Manager is a web application designed to help users manage their fishing sessions. It allows users to create, view, and manage their active fishing records.
wobbleIT is a web application designed for users to manage their fishing sessions. It allows them to track their fishing, check current weather and AI check fish species by photo.

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up --wait` to set up and start a fresh Symfony project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## 📦 Technologies

- PHP 8+
- Symfony
- Doctrine ORM
- PostgreSQL
- Twig
- Tailwind CSS

## 🚀 Features

- User login and authentication
- Email verification
- Management of fishing sessions (`Fishing` entity)
- Managing catched fish (`Fish` entity)
- Assigning fishing sessions to users
- Embedded Fishing locations map from .kml file
- Fish validation (length, protection period, daily limit)
- Weather API
- AI check fish species by photo