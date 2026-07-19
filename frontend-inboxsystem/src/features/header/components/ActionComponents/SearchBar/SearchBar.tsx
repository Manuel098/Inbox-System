import { useState, useRef, useEffect } from "react";
import { SearchIcon } from "../../../../../components/ui";

const SearchBar = () => {
    const [isOpen, setIsOpen] = useState(false);
    const inputRef = useRef<HTMLInputElement>(null);

    // Enfocar el input automáticamente al abrir en modo móvil
    useEffect(() => {
        if (isOpen && inputRef.current) {
            inputRef.current.focus();
        }
    }, [isOpen]);

    return (
        <div className="relative flex items-center justify-end">
            {/* BOTON MOVIL: Solo se ve en pantallas pequeñas si esta cerrado */}
            {!isOpen && (
                <button
                    onClick={() => setIsOpen(true)}
                    className="flex md:hidden h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm active:scale-95 transition-all duration-150"
                    aria-label="Abrir busqueda"
                >
                    <SearchIcon size={18} />
                </button>
            )}

            {/* CONTENEDOR DEL INPUT: 
                - En movil: Es flotante, compacto, mas pequeño (h-9 en vez de h-11) y aparece con animación si isOpen es true.
                - En escritorio (md): Siempre visible, tamaño normal (h-11) y ancho fijo.
            */}
            <div
                className={`
                    ${isOpen 
                        ? "flex absolute right-0 top-1/2 -translate-y-1/2 z-50 h-9 w-60 rounded-lg border-blue-500 ring-4 ring-blue-500/10" 
                        : "hidden"
                    } 
                    md:flex md:static md:translate-y-0 md:h-11 md:w-80 md:rounded-xl md:border-slate-200 md:focus-within:border-blue-500 md:focus-within:ring-4 md:focus-within:ring-blue-500/10
                    items-center bg-white px-3 shadow-sm border transition-all duration-200 hover:border-slate-300
                `}
            >
                <input
                    ref={inputRef}
                    type="text"
                    placeholder="Buscar..."
                    className="flex-1 bg-transparent text-xs md:text-sm text-slate-700 placeholder:text-slate-400 outline-none min-w-0"
                    onBlur={() => setIsOpen(false)} // Se cierra automaticamente al hacer clic afuera
                />

                <SearchIcon
                    size={16}
                    className="text-blue-500 md:text-slate-400 md:group-focus-within:text-blue-500 transition-colors duration-200"
                />
            </div>
        </div>
    );
};

export default SearchBar;
