// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

contract ProductTrace {
    struct Product {
        string name;
        string material;
        uint256 createdAt;
        bool exists;
    }

    mapping(string => Product) private products;

    function addProduct(string memory _id, string memory _name, string memory _material) public returns (
        string memory name,
        string memory material,
        uint256 createdAt
    ) {
        require(!products[_id].exists, "Product already exists");

        products[_id] = Product({
            name: _name,
            material: _material,
            createdAt: block.timestamp,
            exists: true
        });

        // langsung return data produk yang ditambahkan
        Product memory p = products[_id];
        return (p.name, p.material, p.createdAt);
    }

    function getProduct(string memory _id) public view returns (
        string memory name,
        string memory material,
        uint256 createdAt
    ) {
        require(products[_id].exists, "Product not found");
        Product memory p = products[_id];
        return (p.name, p.material, p.createdAt);
    }

    struct ProductionStage {
        string stageName;
        uint256 timestamp;
    }

    mapping(string => ProductionStage[]) private productStages;

    function addProductionStage(string memory _productId, string memory _stageName) public {
        productStages[_productId].push(ProductionStage({
            stageName: _stageName,
            timestamp: block.timestamp
        }));
    }

    function getProductionStageCount(string memory _productId) public view returns (uint256) {
        return productStages[_productId].length;
    }

    function getProductionStageByIndex(string memory _productId, uint256 index) public view returns (string memory, uint256) {
        ProductionStage memory stage = productStages[_productId][index];
        return (stage.stageName, stage.timestamp);
    }
}
