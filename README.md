# Army Modeling Exercise

## Table of Contents
- [Overview](#overview)
- [Problem Statement](#problem-statement)
- [Solution Overview](#solution-overview)
- [Project Structure](#project-structure)
- [Key Components](#key-components)
  - [Entities and Domain Models](#entities-and-domain-models)
  - [Services and Business Logic](#services-and-business-logic)
  - [Strategies and Interfaces](#strategies-and-interfaces)
  - [Factories and Helpers](#factories-and-helpers)
- [Usage Examples](#usage-examples)
- [Future Extensibility](#future-extensibility)
- [Conclusion](#conclusion)

## Overview

This project implements an object-oriented model for simulating armies composed of various unit types. The system handles unit training, unit transformation, and simulates battles between armies from different (or the same) civilizations. The goal is to design a flexible solution that accurately represents the domain while being ready for future extensions (e.g., adding new unit types).

## Problem Statement

The exercise requires modeling an army system with the following constraints and functionalities:

- **Armies**:  
  - Each army starts with a predefined number of units (pikemen, archers, and knights) based on its civilization.
  - Each army is initialized with 1000 gold coins.
  - Armies record a history of all battles in which they participate.

- **Units**:  
  - There are three types of units: Pikeman, Archer, and Knight.
  - Each unit contributes a specific number of points to the army’s strength:
    - **Pikeman**: 5 points  
    - **Archer**: 10 points  
    - **Knight**: 20 points  
  - A unit’s strength can never decrease.

- **Unit Training**:  
  - Each unit can be trained to increase its strength at a cost (with specified gold expenditure and point increase).
  - For example, training a Pikeman increases its strength by 3 points (cost: 10 gold), an Archer by 7 (cost: 20 gold), and a Knight by 10 (cost: 30 gold).

- **Unit Transformation**:  
  - Units can be transformed to another type:
    - A **Pikeman** can transform into an **Archer** (cost: 30 gold).
    - An **Archer** can transform into a **Knight** (cost: 40 gold).
    - A **Knight** cannot be transformed.
  - The transformation should transfer any extra strength gained through training, applying a calculated bonus to the resulting unit.

- **Battles**:  
  - Armies can attack one another at any time, even if they belong to the same civilization.
  - The outcome of the battle is determined by the total strength of each army:
    - **Win**: The winning army (with higher total strength) gains 100 gold coins, while the losing army loses its two most powerful units.
    - **Draw**: In the case of a tie, each army loses one (or a configurable number of) unit, chosen via a removal strategy.

- **Extensibility**:  
  - The system must be designed so that future additions such as a new unit “Mage” (with 50 strength, trainable but not transformable) require minimal code changes.
  - Decisions such as handling multiple trainings and transformations are clearly modeled in the system.

## Solution Overview

The solution uses a fully object-oriented design with clear separation of concerns:

- **Domain Modeling:**  
  - **Entities** represent armies, units, and civilizations.
  - The abstract class `Unit` models common behaviors, while concrete classes (`Pikeman`, `Archer`, and `Knight`) define unit-specific values.
  - The `Army` class manages its collection of units, available gold, and battle history.
  - A `Civilization` aggregates armies and ensures initial unit configurations based on civilization-specific parameters.

- **Business Logic:**  
  - **UnitTrainingService** encapsulates unit training logic, validating gold sufficiency and increasing strength.
  - **UnitTransformationService** handles transforming units—transferring any extra training bonus from the original unit to the new unit.
  - **BattleService** simulates battles between armies, updates gold rewards, removes units (using different strategies), and logs battle history.

- **Extensibility:**  
  - The use of **Factory** (`UnitFactory`) simplifies unit creation, so adding a new unit type will have minimal impact.
  - **Strategies** for unit removal and determination of the most powerful units allow flexible changes in the battle logic without affecting the core services.
  - **Interfaces** enforce contracts among services, strategies, and domain entities for a loosely coupled design.

## Project Structure
```
├── examples
│   ├── different_civilizations_battle.php
│   ├── same_civilization_battle.php
│   ├── unit_transformation_demo.php
│   └── war.php
├── src
│   ├── Entities
│   │   ├── Units
│   │   │   ├── Archer.php
│   │   │   ├── Knight.php
│   │   │   ├── Pikeman.php
│   │   │   └── Unit.php
│   │   ├── Army.php
│   │   └── Civilization.php
│   ├── Factories
│   │   └── UnitFactory.php
│   ├── Helpers
│   │   └── Formatter.php
│   ├── Interfaces
│   │   ├── ArmyInterface.php
│   │   ├── CivilizationInterface.php
│   │   ├── DrawUnitsRemovalStrategyInterface.php
│   │   └── MostPowerfulUnitsStrategyInterface.php
│   ├── Services
│   │   ├── BattleService.php
│   │   ├── UnitTrainingService.php
│   │   └── UnitTransformationService.php
│   └── Strategies
│       ├── IterativeMostPowerfulUnitsStrategy.php
│       ├── RandomUnitsRemovalStrategy.php
│       └── SortMostPowerfulUnitsStrategy.php
├── vendor
│   └── ... (Composer dependencies)
├── composer.json
└── composer.lock
```
## Key Components

### Entities and Domain Models

- **Unit (Abstract) & Concrete Units:**  
  Define properties like `BASE_STRENGTH`, `TRAINING_COST`, and methods for training and retrieving current strength.  
- **Army:**  
  Manages units, tracks gold (starting at 1000), and records battle history. It includes methods to add or remove units and calculate total strength.
- **Civilization:**  
  Responsible for creating and managing armies. Uses a standardized naming format to prevent duplicates.

### Services and Business Logic

- **UnitTrainingService:**  
  Validates if the army has sufficient gold before training a unit and applies the strength increase.
- **UnitTransformationService:**  
  Handles the transformation of one unit type to another (e.g., Pikeman → Archer) while calculating and transferring extra strength from previous training.
- **BattleService:**  
  Determines the winner (or if it's a draw), rewards gold to the winner, removes the top units from the losing side, and logs battle results.

### Strategies and Interfaces

- **Interfaces:**  
  Define contracts for army operations, civilization operations, and strategies to determine the most powerful units or units to remove in a draw.
- **Strategies:**  
  Two approaches are provided (iterative and sort-based) for determining which units are removed during a battle. The Random removal strategy is used for handling draws.

### Factories and Helpers

- **UnitFactory:**  
  Centralizes the creation of unit objects, making it simple to add new unit types.
- **Formatter:**  
  Ensures consistency in formatting names (e.g., for armies) to avoid conflicts due to different naming conventions.

## Usage Examples

The project includes several examples in the `examples` folder. These scripts demonstrate:
- Creating armies with different civilizations
- Training and transforming units
- Simulating battles between armies (both within the same civilization and with different ones)

Run an example via the command line with PHP (for example):
```
php examples/war.php
```

This script will simulate a complete war scenario using the services and strategies defined in the project.

## Future Extensibility
Adding New Unit Types (e.g., Mage):
To add a new unit such as the Mage (50 strength, trainable, non-transformable), you only need to:

- Create a new class (e.g., Mage.php) inside the Entities/Units folder.

- Update the UnitFactory to handle the new unit type.

- (Optionally) update training and transformation logic if necessary.

Enhancements to Battle Mechanics:
Strategies for unit removal in battles or more complex battle rules can be easily swapped or extended using the provided interfaces.
