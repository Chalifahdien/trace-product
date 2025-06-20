const express = require("express");
const cors = require("cors");
const { ethers } = require("ethers");
require("dotenv").config();

const app = express();
app.use(cors());
app.use(express.json());

// Inisialisasi Ethereum provider dan signer
const provider = new ethers.providers.JsonRpcProvider(process.env.RPC_URL);
const signer = new ethers.Wallet(process.env.PRIVATE_KEY, provider);

// Import ABI dan contract address
const contractABI = require("./abi/ProductTrace.json").abi;
const contractAddress = process.env.CONTRACT_ADDRESS;

const contract = new ethers.Contract(contractAddress, contractABI, signer);

/* -------------------------------------------------------------------------- */
/*                                PRODUCT API                                 */
/* -------------------------------------------------------------------------- */

// Simpan produk baru
app.post("/store-product", async (req, res) => {
    const { productId, name, material } = req.body;

    try {
        const tx = await contract.addProduct(productId, name, material);
        await tx.wait();
        res.json({ success: true, txHash: tx.hash });
    } catch (err) {
        console.error("Error:", err.message);
        res.status(500).json({ success: false, error: err.message });
    }
});

// Ambil 1 produk
app.get("/get-product/:productId", async (req, res) => {
    try {
        const productId = req.params.productId.trim();
        const [name, material, createdAt] = await contract.getProduct(productId);

        res.json({
            name,
            material,
            createdAt: parseInt(createdAt)
        });
    } catch (err) {
        console.error("GET PRODUCT ERROR:", err);
        res.status(500).json({ success: false, error: err.message });
    }
});

// Ambil semua produk
app.get("/products", async (req, res) => {
    try {
        const ids = await contract.getAllProductIds();
        const result = [];

        for (const id of ids) {
            const [name, material, createdAt, totalStages, totalDistributors] = await contract.getProduct(id);
            result.push({
                id,
                name,
                material,
                createdAt: parseInt(createdAt),
                totalStages: totalStages.toNumber(),
                totalDistributors: totalDistributors.toNumber()
            });
        }

        res.json(result);
    } catch (err) {
        console.error("GET ALL PRODUCTS ERROR:", err);
        res.status(500).json({ error: err.message });
    }
});

/* -------------------------------------------------------------------------- */
/*                            PRODUCTION STAGE API                            */
/* -------------------------------------------------------------------------- */

// Tambah tahapan produksi
app.post('/add-stage', async (req, res) => {
    const { productId, stageName } = req.body;

    try {
        const tx = await contract.addProductionStage(productId, stageName);
        await tx.wait();
        res.json({ message: 'Stage added', txHash: tx.hash });
    } catch (error) {
        console.error('Blockchain error:', error);
        res.status(500).json({ error: 'Failed to add stage' });
    }
});

// Ambil semua tahapan produksi
app.get('/get-stages/:productId', async (req, res) => {
    const { productId } = req.params;

    try {
        const [stageNames, timestamps] = await contract.getAllStages(productId);
        const stages = stageNames.map((name, index) => ({
            stageName: name,
            timestamp: timestamps[index].toNumber()
        }));

        res.json(stages);
    } catch (error) {
        console.error('Gagal ambil data stage:', error);
        res.status(500).json({ error: 'Gagal ambil data dari blockchain' });
    }
});

/* -------------------------------------------------------------------------- */
/*                              DISTRIBUTOR API                               */
/* -------------------------------------------------------------------------- */

// Tambah distributor
app.post('/add-distributor', async (req, res) => {
    const { productId, destination } = req.body;

    try {
        const tx = await contract.addDistributor(productId, destination);
        await tx.wait();
        res.json({ message: 'Distributor added', txHash: tx.hash });
    } catch (error) {
        console.error('Blockchain error:', error);
        res.status(500).json({ error: 'Failed to add distributor' });
    }
});

// Ambil semua distributor
app.get('/get-distributors/:productId', async (req, res) => {
    const { productId } = req.params;

    try {
        const [users, destinations, timestamps] = await contract.getAllDistributors(productId);
        const distributors = users.map((user, index) => ({
            address: user,
            destination: destinations[index],
            timestamp: timestamps[index].toNumber()
        }));

        res.json(distributors);
    } catch (error) {
        console.error('Gagal ambil data distributor:', error);
        res.status(500).json({ error: 'Gagal ambil data distributor' });
    }
});

app.get('/get-all-blocks', async (req, res) => {
    try {
        const latestBlockNumber = await provider.getBlockNumber();
        const blocks = [];

        for (let i = 0; i <= latestBlockNumber; i++) {
            const block = await provider.getBlockWithTransactions(i);
            blocks.push({
                blockNumber: block.number,
                timestamp: block.timestamp,
                hash: block.hash,
                parentHash: block.parentHash,
                miner: block.miner,
                gasUsed: block.gasUsed.toString(),
                transactions: block.transactions.map(tx => ({
                    hash: tx.hash,
                    from: tx.from,
                    to: tx.to,
                    value: tx.value.toString(),
                    data: tx.data
                }))
            });
        }

        res.json(blocks);
    } catch (error) {
        console.error('Gagal mengambil semua block:', error);
        res.status(500).json({ error: 'Gagal mengambil block dari blockchain' });
    }
});



/* -------------------------------------------------------------------------- */

const PORT = 3001;
app.listen(PORT, () => {
    console.log("🟢 Node.js blockchain middleware aktif di http://localhost:" + PORT);
});
