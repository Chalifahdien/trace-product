const hre = require("hardhat");

async function main() {
    const ProductTrace = await hre.ethers.getContractFactory("ProductTrace");
    const productTrace = await ProductTrace.deploy();

    await productTrace.waitForDeployment(); // ✅ versi ethers.js terbaru

    console.log("Contract deployed to:", await productTrace.getAddress());
}

main().catch((error) => {
    console.error(error);
    process.exitCode = 1;
});

// Contract deployed to: 0x9fE46736679d2D9a65F0992F2272dE9f3c7fa6e0
// const contract = await ProductTrace.attach("0x9fE46736679d2D9a65F0992F2272dE9f3c7fa6e0") 