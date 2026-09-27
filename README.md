![StockSync Enterprise Cover](cover.png)

🇺🇸 [Read in English](#english-version) | 🇪🇸 [Leer en Español](#spanish-version)

---

<a name="spanish-version"></a>
# 🇪🇸 Versión en Español

**StockSync Enterprise** es un sistema de planificación de recursos (ERP) y gestión de inventarios diseñado para operaciones logísticas, control de bodegas y auditoría física de stock. 

A diferencia de plantillas genéricas, StockSync está diseñado con lógica operativa real, facilitando flujos de trabajo como conteos físicos, detección de mermas y sincronización masiva mediante hojas de Excel.

## 🚀 Características Principales
*   **Motor de Sincronización Excel:** Importación/exportación bidireccional (`.xlsx`, `.xls`, `.csv`) con validación automática y prevención de duplicidad (Upsert).
*   **Auditoría Física:** Trazabilidad de entradas, salidas y mermas con registro de usuario y fecha.
*   **Monitor en Tiempo Real:** Panel ejecutivo con KPIs en vivo (capital invertido, alertas de quiebre).
*   **Diseño Premium:** Interfaz corporativa responsive construida con Tailwind CSS, optimizada para ordenadores y terminales móviles de bodega.
*   **Soporte Multilingüe:** Sistema preparado para traducciones nativas (i18n).

## 📖 Manual de Uso Rápido

Una vez instalado, sigue este flujo operativo para poner en marcha tu almacén:

### 1. Configuración de Categorías (Taxonomía)
Antes de ingresar productos, debes definir la estructura de tu bodega:
*   Ve al menú **Categorías**.
*   Haz clic en "Nueva Categoría".
*   Asigna nombres descriptivos (Ej. "Herramientas Eléctricas", "Consumibles").
*   *Nota de seguridad:* El sistema protege la integridad de los datos. No podrás eliminar una categoría si tiene productos vinculados.

### 2. Carga de Inventario Base (Sincronización Excel)
Para evitar la carga manual tediosa, usa el motor de Excel:
*   Ve al menú **Inventario**.
*   Haz clic en "Exportar Datos" para obtener la plantilla base oficial.
*   Llena el Excel con tus SKUs, Nombres, Precios, Stock Actual y Stock Mínimo.
*   Haz clic en "Importar Excel" y sube el archivo. El motor creará los productos nuevos y actualizará automáticamente las cantidades de los SKUs que ya existan (Upsert).

### 3. Operación Diaria (Auditoría Física)
Para registrar el movimiento diario de bodega (entradas de proveedor, despachos o pérdidas):
*   Ve al menú **Auditoría Física**.
*   Registra un nuevo movimiento seleccionando el producto, el tipo (Entrada, Salida, Ajuste/Merma) y la cantidad.
*   Este movimiento actualizará automáticamente el inventario general y quedará grabado con fecha y nombre del operario responsable para trazabilidad.

### 4. Supervisión (Dashboard)
Los gerentes o jefes de bodega pueden usar el **Panel de Control** para ver métricas clave en vivo:
*   **Capital Invertido:** Valoración dinámica del stock multiplicada por su precio de venta.
*   **Alertas Críticas:** Identificación inmediata de SKUs cuyo inventario físico ha caído por debajo de la alerta mínima configurada, facilitando las órdenes de reposición.

## ⚙️ Instalación Local

1. `git clone https://github.com/santiamm/stocksync-enterprise.git`
2. `cd stocksync-enterprise`
3. `composer install && npm install`
4. `cp .env.example .env && php artisan key:generate`
5. Configura `DB_CONNECTION=sqlite` en el archivo `.env`. (Borra o comenta los campos `DB_HOST`, `DB_PORT`, `DB_DATABASE`, etc).
6. Crea el archivo de base de datos vacío: `touch database/database.sqlite` (en Windows puedes usar `type nul > database/database.sqlite`).
7. `php artisan migrate`
8. Inicia los servidores en dos terminales distintas: `php artisan serve` y `npm run dev`.

---

<a name="english-version"></a>
# 🇺🇸 English Version

**StockSync Enterprise** is an Enterprise Resource Planning (ERP) and inventory management system designed for logistics operations, warehouse control, and physical stock auditing.

Unlike generic templates, StockSync is built with real-world operational logic, streamlining workflows like physical counts, shrinkage detection, and bulk synchronization via Excel spreadsheets.

## 🚀 Key Features
*   **Excel Sync Engine:** Bidirectional import/export (`.xlsx`, `.xls`, `.csv`) with automatic validation and SKU duplication prevention (Upsert).
*   **Physical Auditing:** Full traceability of inbound, outbound, and stock adjustments (shrinkage) with user and timestamp logging.
*   **Real-Time Monitor:** Executive dashboard featuring live KPIs (invested capital, stockout alerts).
*   **Premium Design:** Corporate responsive UI built with Tailwind CSS, optimized for desktop and mobile warehouse terminals.
*   **Multilingual Support:** System prepared for native translations (i18n).

## 📖 Quick Start Guide

Once installed, follow this operational flow to get your warehouse running:

### 1. Category Setup (Taxonomy)
Before adding products, you must define your warehouse structure:
*   Go to the **Categories** menu.
*   Click on "New Category".
*   Assign descriptive names (e.g., "Power Tools", "Consumables").
*   *Security Note:* The system protects data integrity. You cannot delete a category if it has linked products.

### 2. Base Inventory Loading (Excel Synchronization)
Avoid tedious manual entry by using the Excel engine:
*   Go to the **Inventory** menu.
*   Click "Export Data" to get the official base template.
*   Fill the Excel file with your SKUs, Names, Prices, Current Stock, and Minimum Stock Alerts.
*   Click "Import Excel" and upload the file. The engine will create new products and automatically update the quantities of existing SKUs (Upsert).

### 3. Daily Operations (Physical Audit)
To log daily warehouse movements (supplier inbound, dispatches, or losses):
*   Go to the **Physical Audit** menu.
*   Record a new movement by selecting the product, type (Inbound, Outbound, Adjustment/Shrinkage), and quantity.
*   This movement will automatically update the master inventory and will be logged with the timestamp and the responsible operator's name for traceability.

### 4. Supervision (Dashboard)
Managers or warehouse supervisors can use the **Dashboard** to view live key metrics:
*   **Invested Capital:** Dynamic valuation of stock multiplied by its selling price.
*   **Critical Alerts:** Immediate identification of SKUs where physical inventory has fallen below the configured minimum alert, streamlining replenishment orders.

## ⚙️ Local Installation

1. `git clone https://github.com/santiamm/stocksync-enterprise.git`
2. `cd stocksync-enterprise`
3. `composer install && npm install`
4. `cp .env.example .env && php artisan key:generate`
5. Set `DB_CONNECTION=sqlite` in the `.env` file. (Delete or comment out fields like `DB_HOST`, `DB_PORT`, `DB_DATABASE`, etc).
6. Create the empty database file: `touch database/database.sqlite` (on Windows use `type nul > database/database.sqlite`).
7. `php artisan migrate`
8. Start the servers in two separate terminals: `php artisan serve` and `npm run dev`.