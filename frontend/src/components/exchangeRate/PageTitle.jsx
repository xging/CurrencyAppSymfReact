const PageTitle = ({ currency, lastUpdateDate }) => {
    return (
        <div>
                    <h2 className="text-center mb-2">1 {currency.replace("-", " to ")} Exchange Rate</h2>
                    <p className="text-center">Last updated: {lastUpdateDate}</p>
        </div>

    );
};
export default PageTitle;