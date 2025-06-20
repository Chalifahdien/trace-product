async function main() {
    const [deployer] = await ethers.getSigners();

    console.log("Deploying contract with:", deployer.address);

    const ProductTrace = await ethers.getContractFactory("ProductTrace");
    const contract = await ProductTrace.deploy();

    const deployedContract = await contract.waitForDeployment(); // ✅ tunggu kontrak siap
    console.log("ProductTrace deployed to:", await deployedContract.getAddress()); // ✅ ambil alamat dengan cara baru
}

main().catch((error) => {
    console.error(error);
    process.exitCode = 1;
});



// Deploying contract with: 0xf39Fd6e51aad88F6F4ce6aB8827279cffFb92266
// ProductTrace deployed to: 0x5FbDB2315678afecb367f032d93F642f64180aa3
// const contract = await ethers.getContractAt("ProductTrace", "0x5FbDB2315678afecb367f032d93F642f64180aa3");
