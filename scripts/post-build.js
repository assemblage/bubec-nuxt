const fs = require('fs');

fs.copyFile("./.htaccess", "./dist/.htaccess", (err) => {
  if (err) {
    console.log("Error Found:", err);
  }

});
