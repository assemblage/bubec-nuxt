# Use official Node.js image (ensure compatibility with Nuxt 2)
FROM node:16.15.0

# Set working directory
WORKDIR /app

# Install system CA certificates
RUN apt-get update && apt-get install -y ca-certificates && update-ca-certificates

# Copy package files and install dependencies
COPY package.json yarn.lock ./
RUN yarn install --no-optional

# Copy project files
COPY . .

# Set environment variables to use custom CA if needed
ENV NODE_EXTRA_CA_CERTS=/etc/ssl/certs/ca-certificates.crt

# Expose Nuxt development port
EXPOSE 3000

# Default command: Run Nuxt in development mode
CMD ["npm", "run", "dev"]