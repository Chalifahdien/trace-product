require("@nomicfoundation/hardhat-toolbox");

module.exports = {
  solidity: "0.8.20",
  networks: {
    localhost: {
      url: "http://127.0.0.1:8545"
    }
  }
};

// Contract deployed to: 0x5FbDB2315678afecb367f032d93F642f64180aa3
// const contract = await ProductTrace.attach("0x5FbDB2315678afecb367f032d93F642f64180aa3")

// 1. npx hardhat node 
// 2. npx hardhat run scripts/deploy.js --network localhost

// 3. Copy contract address ke .ENV
// 4. node app.js

// npx hardhat console --network localhost testing console
// > const [owner] = await ethers.getSigners()
// undefined
// > const ProductTrace = await ethers.getContractFactory("ProductTrace")
// undefined
// > const contract = await ProductTrace.attach("0x5FbDB2315678afecb367f032d93F642f64180aa3")