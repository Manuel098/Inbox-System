import { Header } from '../../features/header';
import { LayoutProps } from '../../interfaces/LayoutInterfaces';
import styles from './Layout.module.css';

export default function Layout(
    // { sidebar, children, }: LayoutProps
) {
  return (
    <div className={styles.container}>
        <Header className={`${styles.header} bg-white text-white shadow-md`} />

        <main className={styles.main}>
            <aside className={`${styles.sidebar} bg-white border-r`} >
                SIDEBAR
                {/* {sidebar} */}
            </aside>

            <section className={`${styles.content} bg-gray-50`} >
                CONTENT
                {/* {children} */}
            </section>
        </main>
    </div>
  );
}