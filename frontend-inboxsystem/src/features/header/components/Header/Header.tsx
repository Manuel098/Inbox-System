import Logo from "../Logo";
import HeaderActions from "../HeaderActions";
import { HeaderProps } from "../../../../interfaces/HeaderInterfaces";

import styles from "./Header.module.css";

const Header = ({ className } : HeaderProps) => {
    return (
        <header className={`${styles.header} ${className ?? ""} w-full h-16 border-b border-slate-200 bg-white`}>
            <div className=" mx-auto flex h-full w-full max-w-screen-2xl items-center justify-between px-4 lg:px-8 ">
                <Logo />
                <HeaderActions />
            </div>
        </header>
    );
};

export default Header;