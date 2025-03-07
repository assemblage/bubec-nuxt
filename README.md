Nuxt 2 - Netlify Docker Compose Environment

This project runs a Nuxt 2 application inside a Docker container using Docker Compose, fully emulating Netlify's environment.

---------------------------------------------------

🚀 Quick Start
---------------------------------------------------

1️⃣ Ensure you have Docker and Docker Compose installed.

2️⃣ Build and start the project:

docker-compose up --build

Open <http://localhost:3000> in your browser.

---------------------------------------------------

⚡ Production Build (Static Site)
---------------------------------------------------

1️⃣ Generate Static Files
--------------------------

docker-compose run nuxt npm run generate

Generated files will be inside the dist/ directory.

2️⃣ Serve Static Site
----------------------

docker-compose run -p 3000:3000 nuxt npm run start

Open <http://localhost:3000>.

---------------------------------------------------

🛠️ Useful Commands
---------------------------------------------------

Build and start in development mode
===========================================

docker-compose up --build

Start the project (without rebuilding)
===========================================

docker-compose up

Stop running containers
===========================================

docker-compose down

Generate static files for production
===========================================

docker-compose run nuxt npm run generate

Serve the generated static site
===========================================

docker-compose run -p 3000:3000 nuxt npm run start

Rebuild everything from scratch
===========================================

docker-compose down && docker-compose build --no-cache && docker-compose up

---------------------------------------------------

🛑 Stopping the Containers
---------------------------------------------------

To stop a running container, press CTRL + C or run:

docker-compose down

---------------------------------------------------

📦 What's Inside?
---------------------------------------------------

- Runs Nuxt 2 with Docker Compose
- Node.js 16.15.0 (Same as Netlify)
- Auto-reloading in Dev Mode
- Port Mapping (3000:3000 for Nuxt)
- Environment Variables (CI=1, NPM_FLAGS=--no-optional)

---------------------------------------------------

🎯 Notes
---------------------------------------------------

- If you see permission errors, try:

sudo chmod -R 777 node_modules .nuxt

🚀 Now your Nuxt 2 project runs exactly like it does on Netlify, inside Docker Compose! 🎉
