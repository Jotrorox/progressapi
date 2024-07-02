# Use the Node.js image as base
FROM node:latest

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json to container
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application code
COPY . .

# Start the application
CMD ["npm", "run", "start"]