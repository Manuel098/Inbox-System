import { useState } from "react";
import styles from "./HeaderActions.module.css";
import { SearchBar } from "../ActionComponents/SearchBar";
import { Notification } from "../ActionComponents/Notifications";
import { AddThread } from "../ActionComponents/AddThread";
import { Account } from "../ActionComponents/Account";
import { MenuIcon } from "../../../../components/ui";
import { CloseIcon } from "../../../../components/ui";
import { GlobalBtn } from "../../../../components/ui/btn";

const HeaderActions = () => {
    const [isOpen, setIsOpen] = useState(false);

    return (
        <div className={`${styles.actions} flex items-center gap-3 relative`}>
            {/* El buscador se queda fijo y visible en todos los tamaños */}
            <SearchBar />

            {/* VISTA ESCRITORIO: Se oculta en móvil (hidden) y se muestra en md (md:flex) */}
            <div className="hidden md:flex items-center gap-3">
                <Notification />
                <AddThread />
                <Account />
            </div>

            {/* BOTÓN HAMBURGUESA: Solo visible en móvil (md:hidden) */}
            <div className="block md:hidden">
                <GlobalBtn onClick={() => setIsOpen(!isOpen)}  icon={isOpen ? CloseIcon : MenuIcon }/> 
            </div>

            {/* VISTA MÓVIL (MENÚ VERTICAL): Se despliega solo si isOpen es true */}
            {isOpen && (
                <div className="absolute right-0 top-14 w-16 bg-white border border-slate-200 rounded-xl shadow-lg py-3 px-4 flex flex-col gap-4 md:hidden z-40 animate-in fade-in slide-in-from-top-2 duration-200">
                    {/* Alineamos los items verticalmente y a la izquierda */}
                    <div className="flex flex-col items-center">
                        <Notification />
                        <AddThread />
                        <Account />
                    </div>
                </div>
            )}
        </div>
    );
};

export default HeaderActions;
