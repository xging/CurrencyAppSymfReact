const CurrencySelector = ({ currency, availableCurrencies, onCurrencyChange }) => {
    // Check if the currency format is correct
    const [baseCurrency, targetCurrency] = currency?.split("-") || ["", ""];

    // Get unique base currencies from availableCurrencies
    const uniqueBaseCurrencies = [...new Set(availableCurrencies.map(pair => pair.split("-")[0]))];

    // Retrieve target currencies available for the selected base currency
    const uniqueTargetCurrencies = availableCurrencies
        .filter(pair => pair.startsWith(baseCurrency + "-"))
        .map(pair => pair.split("-")[1]);

    // Function to swap the currency pairs
    const swapCurrencies = () => {
        onCurrencyChange(`${targetCurrency}-${baseCurrency}`);
    };
    
    return (
        <div className="mb-3 text-center">
            <label className="form-label">Select Currency:</label>
            <select
                className="form-select d-inline-block w-auto mx-2"
                value={baseCurrency}
                onChange={(e) => {
                    const newBase = e.target.value;
                    const newTarget = availableCurrencies.find(pair => pair.startsWith(newBase + "-"))?.split("-")[1] || "";
                    onCurrencyChange(`${newBase}-${newTarget}`);
                }}
            >
                {uniqueBaseCurrencies.map((base) => (
                    <option key={base} value={base}>{base}</option>
                ))}
            </select>

            <button className="btn btn-outline-secondary mx-2" onClick={swapCurrencies}>⇄</button>

            <select
                className="form-select d-inline-block w-auto mx-2"
                value={targetCurrency}
                onChange={(e) => onCurrencyChange(`${baseCurrency}-${e.target.value}`)}
                disabled={uniqueTargetCurrencies.length === 0}
            >
                {uniqueTargetCurrencies.map((target) => (
                    <option key={target} value={target}>{target}</option>
                ))}
            </select>
        </div>
    );
};

export default CurrencySelector;