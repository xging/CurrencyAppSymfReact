const CurrencyTable = ({ currency, data, sortOrder, setSortOrder}) => {
    return (
        <table className="table table-bordered text-center">
        <thead className="table-light">
            <tr>
                <th onClick={() => setSortOrder(sortOrder === "ASC" ? "DESC" : "ASC")}>Date {sortOrder === "ASC" ? "▲" : "▼"}</th>
                <th>{currency.replace("-", " to ")}</th>
            </tr>
        </thead>
        <tbody>
            {data.map((row, index) => (
                <tr key={index}>
                    <td>{row.update_date}</td>
                    <td>{row.last_rate}</td>
                </tr>
            ))}
        </tbody>
    </table>
    );
};
export default CurrencyTable;