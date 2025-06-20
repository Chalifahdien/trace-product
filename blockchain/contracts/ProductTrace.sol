// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

contract ProductTrace {
    struct ProductionStage {
        string stageName;
        uint256 createdAt;
    }

    struct Distributor {
        address user;
        string destination;
        uint256 createdAt;
    }

    struct Product {
        string id;
        string name;
        string material;
        uint256 createdAt;
        ProductionStage[] stages;
        Distributor[] distributors;
    }

    mapping(string => Product) private products;
    string[] private productIds; // ✅ untuk menyimpan daftar semua ID produk

    event ProductAdded(string id, string name, string material, uint256 createdAt);
    event StageAdded(string productId, string stageName, uint256 createdAt);
    event DistributorAdded(string productId, address user, string destination, uint256 createdAt);

    // ---------------------------
    // Fungsi Tambah Produk
    // ---------------------------
    function addProduct(string memory _id, string memory _name, string memory _material) public {
        require(bytes(products[_id].id).length == 0, "Product already exists");

        Product storage newProduct = products[_id];
        newProduct.id = _id;
        newProduct.name = _name;
        newProduct.material = _material;
        newProduct.createdAt = block.timestamp;

        productIds.push(_id); // ✅ simpan ID produk
        emit ProductAdded(_id, _name, _material, block.timestamp);
    }

    // ---------------------------
    // Fungsi Tambah Tahapan Produksi
    // ---------------------------
    function addProductionStage(string memory _productId, string memory _stageName) public {
        require(bytes(products[_productId].id).length != 0, "Product does not exist");

        products[_productId].stages.push(ProductionStage({
            stageName: _stageName,
            createdAt: block.timestamp
        }));

        emit StageAdded(_productId, _stageName, block.timestamp);
    }

    // ---------------------------
    // Fungsi Tambah Distributor
    // ---------------------------
    function addDistributor(string memory _productId, string memory _destination) public {
        require(bytes(products[_productId].id).length != 0, "Product does not exist");

        products[_productId].distributors.push(Distributor({
            user: msg.sender,
            destination: _destination,
            createdAt: block.timestamp
        }));

        emit DistributorAdded(_productId, msg.sender, _destination, block.timestamp);
    }

    // ---------------------------
    // Get Semua Produk
    // ---------------------------
    function getAllProductIds() public view returns (string[] memory) {
        return productIds;
    }

    // ---------------------------
    // Get Info Produk
    // ---------------------------
    function getProduct(string memory _id) public view returns (
        string memory name,
        string memory material,
        uint256 createdAt,
        uint256 totalStages,
        uint256 totalDistributors
    ) {
        Product storage product = products[_id];
        require(bytes(product.id).length != 0, "Product not found");

        return (
            product.name,
            product.material,
            product.createdAt,
            product.stages.length,
            product.distributors.length
        );
    }

    // ---------------------------
    // Get Semua Tahapan Produksi
    // ---------------------------
    function getAllStages(string memory _productId) public view returns (
        string[] memory names,
        uint256[] memory timestamps
    ) {
        Product storage product = products[_productId];
        uint256 count = product.stages.length;

        names = new string[](count);
        timestamps = new uint256[](count);

        for (uint256 i = 0; i < count; i++) {
            names[i] = product.stages[i].stageName;
            timestamps[i] = product.stages[i].createdAt;
        }
    }

    // ---------------------------
    // Get Semua Distributor
    // ---------------------------
    function getAllDistributors(string memory _productId) public view returns (
        address[] memory users,
        string[] memory destinations,
        uint256[] memory timestamps
    ) {
        Product storage product = products[_productId];
        uint256 count = product.distributors.length;

        users = new address[](count);
        destinations = new string[](count);
        timestamps = new uint256[](count);

        for (uint256 i = 0; i < count; i++) {
            users[i] = product.distributors[i].user;
            destinations[i] = product.distributors[i].destination;
            timestamps[i] = product.distributors[i].createdAt;
        }
    }

    function getProductionStageCount(string memory _productId) public view returns (uint256) {
        return products[_productId].stages.length;
    }

}
