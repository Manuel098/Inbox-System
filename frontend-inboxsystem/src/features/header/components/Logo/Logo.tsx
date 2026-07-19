const Logo = () => {
    return (
        <div className="flex items-center gap-2.5 select-none cursor-pointer group">
            <div className="h-9 w-9 rounded-xl bg-gradient-to-tr from-slate-900 to-slate-700 shadow-sm flex items-center justify-center text-white font-bold text-lg group-hover:scale-105 transition-transform duration-200">
                M
            </div>

            <span className="text-xl font-bold tracking-tight text-slate-900">
                Mi<span className="text-blue-600">Inbox</span>
            </span>
        </div>
    );
};

export default Logo;
