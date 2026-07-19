import { GlobalBtnProps } from "../../../interfaces/GlobalBtnsInterfaces";

// Renombramos 'icon' a 'Icon' en la desestructuración para que React lo reconozca como componente
const NotificationButton = ({ icon: Icon, count = 0, onClick= () => {} }: GlobalBtnProps) => {
  return (
    <button 
      className="relative flex h-10 w-10 items-center justify-center rounded-lg hover:bg-slate-100 transition"
      onClick={onClick}
    >
      <Icon size={20} />
      {count > 0 && (
        <span className="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">
          {count}
        </span>
      )}
    </button>
  );
};

export default NotificationButton;
