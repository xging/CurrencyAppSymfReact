const Pagination = ({ currentPage, totalPages, onPageChange }) => {
    const getPagination = () => {
        const pages = [];
        if (totalPages <= 5) {
            for (let i = 1; i <= totalPages; i++) {
                pages.push(i);
            }
        } else if (currentPage <= 4) {
            pages.push(1, 2, 3, 4, 5, "...", totalPages);
        } else if (currentPage >= totalPages - 3) {
            pages.push(1, "...", totalPages - 4, totalPages - 3, totalPages - 2, totalPages - 1, totalPages);
        } else {
            pages.push(1, "...", currentPage - 2, currentPage - 1, currentPage, currentPage + 1, currentPage + 2, "...", totalPages);
        }

        return pages;
    };

    return (
        <div className="text-center mb-2">
            <button className="btn btn-secondary btn-sm" disabled={currentPage === 1} onClick={() => onPageChange(currentPage - 1)}>
                &lt;
            </button>
            {getPagination().map((page, index) => (
                <button
                    key={index}
                    className={`btn btn-sm mx-1 ${currentPage === page ? "btn-primary" : "btn-light"}`}
                    onClick={() => typeof page === "number" && onPageChange(page)}
                    disabled={page === "..."}
                >
                    {page}
                </button>
            ))}
            <button className="btn btn-secondary btn-sm" disabled={currentPage === totalPages} onClick={() => onPageChange(currentPage + 1)}>
                &gt;
            </button>
        </div>
    );
};

export default Pagination;
